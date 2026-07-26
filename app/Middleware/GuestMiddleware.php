<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\MiddlewareInterface;
use App\Core\Request;

/**
 * Zaten giris yapmis kullaniciyi /login sayfasindan uzaklastirir,
 * dogrudan dashboard'a gonderir. (login ve auth sayfalarinda kullanilir.)
 */
class GuestMiddleware implements MiddlewareInterface
{
    public function handle(Request $request): void
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . url('/admin/dashboard'));
            exit;
        }
    }
}
