<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Tum controller'larin extend edecegi taban sinif.
 * Ortak yardimcilar burada:
 *   - view()     : bir View dosyasini render eder (opsiyonel layout ile)
 *   - redirect() : baska bir URL'e yonlendirir
 *   - back()     : geldigi sayfaya geri gonderir
 */
abstract class Controller
{
    /**
     * View render eder.
     *
     * @param string $view    admin/institutions/index gibi (uzantisiz)
     * @param array  $data    View icinde $degisken olarak kullanilir
     * @param string|null $layout  layouts/admin gibi; null -> layoutsuz render
     */
    protected function view(string $view, array $data = [], ?string $layout = null): void
    {
        $viewPath = App::$basePath . '/app/Views/' . $view . '.php';
        if (!is_file($viewPath)) {
            throw new \RuntimeException("View bulunamadi: $viewPath");
        }

        // View icerigini yakalayip $content degiskenine koyalim,
        // sonra layout icinde $content olarak echo edilir.
        extract($data, EXTR_SKIP);
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if ($layout === null) {
            echo $content;
            return;
        }

        $layoutPath = App::$basePath . '/app/Views/' . $layout . '.php';
        if (!is_file($layoutPath)) {
            throw new \RuntimeException("Layout bulunamadi: $layoutPath");
        }
        require $layoutPath;
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . url($path));
        exit;
    }

    protected function back(): void
    {
        $ref = $_SERVER['HTTP_REFERER'] ?? url('/');
        header('Location: ' . $ref);
        exit;
    }
}
