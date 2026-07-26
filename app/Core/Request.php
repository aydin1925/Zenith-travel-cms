<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Request: HTTP istegini tek nesnede toplar.
 * Router bu nesneye bakip hangi rotaya gidecegine karar verir.
 * Controller da $_GET / $_POST'a dogrudan bakmak yerine buna sorar.
 */
class Request
{
    public string $method;
    public string $path;
    public array $query;
    public array $body;

    public function __construct()
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->path   = $this->resolvePath();
        $this->query  = $_GET;
        $this->body   = $_POST;
    }

    /**
     * URL'den uygulama-goreli path'i cikarir.
     * Ornek:
     *   REQUEST_URI  = /Zenith/public/admin/institutions?x=1
     *   SCRIPT_NAME  = /Zenith/public/index.php
     *   dirname()    = /Zenith/public
     *   Sonuc        = /admin/institutions
     * Bu sayede uygulama kokte de calisir, alt klasorde de.
     */
    private function resolvePath(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        // Ornek: SCRIPT_NAME = /Zenith/public/index.php  ->  scriptDir = /Zenith/public
        // Ama kok .htaccess rewrite'i sebebiyle URL'de /public gorunmez.
        // Onu icin iki adayi da denemek: once /Zenith/public, sonra /Zenith.
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));

        $candidates = [$scriptDir];
        if (str_ends_with($scriptDir, '/public')) {
            $candidates[] = substr($scriptDir, 0, -strlen('/public'));
        }

        foreach ($candidates as $base) {
            if ($base !== '' && $base !== '/' && str_starts_with($path, $base)) {
                $path = substr($path, strlen($base));
                break;
            }
        }

        $path = '/' . ltrim($path, '/');
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }
        return $path;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $this->query[$key] ?? $default;
    }

    public function isPost(): bool
    {
        return $this->method === 'POST';
    }
}
