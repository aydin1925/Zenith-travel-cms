<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Zenith CMS - Front Controller
|--------------------------------------------------------------------------
| Tum HTTP istekleri (.htaccess sayesinde) buraya dusuyor.
| Buradaki isimiz cok kucuk:
|   1) Composer autoloader'i yukle,
|   2) Uygulamayi bootla (env, session, hata modu),
|   3) Rotalari yukle,
|   4) Istegi router'a devret.
| Hepsi bu. Is mantigi buraya sizmayacak.
*/

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

use App\Core\App;
use App\Core\Router;
use App\Core\Request;

// Uygulamayi baslat: .env oku, session ac, hata modunu ayarla
App::boot(BASE_PATH);

// Router'i olustur ve rotalari yukle
$router = new Router();
require BASE_PATH . '/routes/web.php';

// Istegi dispatch et; herhangi bir Throwable duserse App yakalar
try {
    $router->dispatch(new Request());
} catch (\Throwable $e) {
    if (env('APP_DEBUG', false)) {
        // Gelistirme modunda hatayi olduğu gibi göster
        throw $e;
    }
    http_response_code(500);
    require BASE_PATH . '/app/Views/errors/500.php';
}
