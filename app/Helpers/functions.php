<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Global yardimci fonksiyonlar
|--------------------------------------------------------------------------
| composer.json'da "files" listesine ekli oldugu icin
| her istekte otomatik yuklenir; her yerden cagirabilirsin.
*/

if (!function_exists('env')) {
    /**
     * .env'den okur. Yoksa varsayilan dondurur.
     */
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        if ($value === false || $value === null) return $default;

        // "true"/"false" gibi string'leri normalize et
        $lower = strtolower((string)$value);
        return match ($lower) {
            'true', '(true)'   => true,
            'false', '(false)' => false,
            'null', '(null)'   => null,
            'empty', '(empty)' => '',
            default            => $value,
        };
    }
}

if (!function_exists('e')) {
    /**
     * HTML'e guvenli sekilde yazdirmak icin (XSS koruma).
     * View'da her zaman <?= e($service['title']) ?> yaz.
     */
    function e(?string $value): string
    {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

if (!function_exists('url')) {
    /**
     * Uygulamanin base URL'ine gore tam URL uretir.
     * url('/admin/institutions')  ->  http://localhost/Zenith/public/admin/institutions
     */
    function url(string $path = '/'): string
    {
        $base = rtrim((string)env('APP_URL', ''), '/');
        if ($base === '') {
            // env verilmediyse SCRIPT_NAME'den turet
            $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
            $base = rtrim(($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $scriptDir, '/');
        }
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    /**
     * public/assets/... icin URL uretir.
     * asset('css/admin_dashboard.css') -> http://.../Zenith/public/assets/css/admin_dashboard.css
     */
    function asset(string $path): string
    {
        return url('/assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): never
    {
        header('Location: ' . url($path));
        exit;
    }
}

if (!function_exists('old')) {
    /**
     * Form validasyon hatasi sonrasi input'a eski degeri yazmak icin.
     * Su an minimal; ileride flash session ile genisletiriz.
     */
    function old(string $key, mixed $default = ''): mixed
    {
        return $_SESSION['_old'][$key] ?? $default;
    }
}

if (!function_exists('flash')) {
    /**
     * flash('success', 'Kaydedildi') -> yazar
     * flash('success')               -> okur ve siler (tek seferlik)
     */
    function flash(string $key, ?string $value = null): ?string
    {
        if ($value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return null;
        }
        $val = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $val;
    }
}
