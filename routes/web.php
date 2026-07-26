<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Web Rotalari
|--------------------------------------------------------------------------
| $router burada tanimli oldugu icin dogrudan kullanabilirsin.
| Grup icindeki rotalar prefix ve middleware'i otomatik alir.
*/

use App\Controllers\AuthController;
use App\Controllers\PublicController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\InstitutionController;
use App\Controllers\Admin\ServiceController;
use App\Controllers\Admin\VehicleController;
use App\Controllers\Admin\SettingController;
use App\Controllers\Admin\MessageController;

/** @var \App\Core\Router $router */

// ============ PUBLIC SITE ============
$router->get('/', [PublicController::class, 'home']);

// Diger nav linkleri simdilik placeholder (coming soon).
// Her biri kendi sayfasina cevrildikce buradan cikacak.
$router->get('/hakkimizda',      [PublicController::class, 'about']);
$router->get('/hizmetlerimiz',   [PublicController::class, 'services']);
$router->get('/filo',            [PublicController::class, 'fleet']);
$router->get('/rotalar',         [PublicController::class, 'routes']);
$router->get('/referanslarimiz', [PublicController::class, 'references']);
$router->get('/sss',             [PublicController::class, 'faq']);
$router->get('/iletisim',        [PublicController::class, 'contact']);
$router->post('/iletisim',       [PublicController::class, 'contactSubmit']);
$router->get('/teklif-al',       [PublicController::class, 'quote']);
$router->post('/teklif-al',      [PublicController::class, 'quoteSubmit']);

// Auth (guest middleware -> giris yapmissan login sayfasina takilma)
$router->group(['middleware' => 'guest'], function ($r) {
    $r->get('/login',  [AuthController::class, 'showLogin']);
    $r->post('/login', [AuthController::class, 'login']);
});

$router->get('/logout', [AuthController::class, 'logout']);

// Admin (auth middleware -> giris yapmadan bakamazsin)
$router->group(['prefix' => 'admin', 'middleware' => 'auth'], function ($r) {

    $r->get('/dashboard', [DashboardController::class, 'index']);

    // Institutions
    $r->get('/institutions',                  [InstitutionController::class, 'index']);
    $r->post('/institutions',                 [InstitutionController::class, 'store']);
    $r->post('/institutions/{id}/update',     [InstitutionController::class, 'update']);
    $r->get('/institutions/{id}/delete',      [InstitutionController::class, 'destroy']);

    // Vehicles
    $r->get('/vehicles',                      [VehicleController::class, 'index']);
    $r->post('/vehicles',                     [VehicleController::class, 'store']);
    $r->post('/vehicles/{id}/update',         [VehicleController::class, 'update']);
    $r->get('/vehicles/{id}/delete',          [VehicleController::class, 'destroy']);

    // Services
    $r->get('/services',                      [ServiceController::class, 'index']);
    $r->post('/services',                     [ServiceController::class, 'store']);
    $r->post('/services/{id}/update',         [ServiceController::class, 'update']);
    $r->get('/services/{id}/delete',          [ServiceController::class, 'destroy']);

    // Settings (sirket profili — tek kayit)
    $r->get('/settings',                      [SettingController::class, 'edit']);
    $r->post('/settings',                     [SettingController::class, 'update']);
    $r->get('/settings/telegram-test',        [SettingController::class, 'telegramTest']);

    // Messages (gelen mesajlar)
    $r->get('/messages',                      [MessageController::class, 'index']);
    $r->get('/messages/{id}',                 [MessageController::class, 'show']);
    $r->get('/messages/{id}/toggle-read',     [MessageController::class, 'toggleRead']);
    $r->get('/messages/{id}/delete',          [MessageController::class, 'destroy']);
});
