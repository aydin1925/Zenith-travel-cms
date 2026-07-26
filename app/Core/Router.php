<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Router: gelen isteğin path'ine ve method'una bakip
 * dogru Controller@method'u calistirir.
 *
 * Ozellikler:
 *  - get() / post() ile rota kaydi
 *  - group(['prefix' => 'admin', 'middleware' => 'auth'], ...) ile toplu kural
 *  - {id} gibi dinamik parametreler
 *  - Middleware alias -> class eslesmesi ($middlewareMap)
 *
 * Rota nasil saklanir? Basit bir dizi olarak:
 *   [ 'method' => 'GET', 'path' => '/admin/institutions/{id}',
 *     'action' => [Class, 'method'], 'middlewares' => ['auth'], 'regex' => '#^...$#' ]
 */
class Router
{
    /** @var array<int, array<string,mixed>> */
    private array $routes = [];

    /** @var array<int, array<string,mixed>> Aktif grup baglami (stack) */
    private array $groupStack = [];

    /** Middleware alias -> tam sinif adi */
    private array $middlewareMap = [
        'auth'  => \App\Middleware\AuthMiddleware::class,
        'guest' => \App\Middleware\GuestMiddleware::class,
    ];

    public function get(string $path, array|callable $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, array|callable $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    /**
     * Grup icindeki tum rotalara ortak prefix ve middleware uygular.
     * Icice cagrilabilir; groupStack sayesinde birikirler.
     */
    public function group(array $attributes, callable $callback): void
    {
        $this->groupStack[] = $attributes;
        $callback($this);
        array_pop($this->groupStack);
    }

    private function addRoute(string $method, string $path, array|callable $action): void
    {
        // Aktif gruplarin prefix ve middleware'lerini birlestir
        $prefix = '';
        $middlewares = [];
        foreach ($this->groupStack as $group) {
            if (!empty($group['prefix'])) {
                $prefix .= '/' . trim($group['prefix'], '/');
            }
            if (!empty($group['middleware'])) {
                $mw = $group['middleware'];
                $middlewares = array_merge($middlewares, is_array($mw) ? $mw : [$mw]);
            }
        }

        $fullPath = $prefix . '/' . ltrim($path, '/');
        $fullPath = '/' . trim($fullPath, '/');
        if ($fullPath === '') $fullPath = '/';

        // {id} gibi placeholder'lari yakalayan regex uret
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $fullPath);
        $regex = '#^' . $regex . '$#';

        $this->routes[] = [
            'method'      => $method,
            'path'        => $fullPath,
            'action'      => $action,
            'middlewares' => $middlewares,
            'regex'       => $regex,
        ];
    }

    public function dispatch(Request $request): void
    {
        // HEAD istekleri, tanimli GET rotasi ile eslesir (HTTP standardi)
        $requestMethod = $request->method === 'HEAD' ? 'GET' : $request->method;

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) continue;
            if (!preg_match($route['regex'], $request->path, $matches)) continue;

            // URL parametrelerini isim -> deger olarak ayikla ({id} -> 5)
            $params = [];
            foreach ($matches as $k => $v) {
                if (!is_int($k)) $params[$k] = $v;
            }

            // Middleware'leri sirayla calistir
            foreach ($route['middlewares'] as $alias) {
                $class = $this->middlewareMap[$alias] ?? $alias;
                if (!class_exists($class)) {
                    throw new \RuntimeException("Middleware bulunamadi: $alias");
                }
                (new $class())->handle($request);
            }

            // Action'i calistir: [ControllerClass, 'method'] veya closure
            $this->callAction($route['action'], $request, $params);
            return;
        }

        // Hicbir rota eslesmedi -> 404
        http_response_code(404);
        require App::$basePath . '/app/Views/errors/404.php';
    }

    private function callAction(array|callable $action, Request $request, array $params): void
    {
        if (is_array($action)) {
            [$class, $method] = $action;
            if (!class_exists($class)) {
                throw new \RuntimeException("Controller bulunamadi: $class");
            }
            $instance = new $class();
            if (!method_exists($instance, $method)) {
                throw new \RuntimeException("Method bulunamadi: $class::$method");
            }
            $instance->$method($request, ...array_values($params));
        } else {
            $action($request, ...array_values($params));
        }
    }
}
