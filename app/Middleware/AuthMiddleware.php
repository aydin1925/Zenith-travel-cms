<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\MiddlewareInterface;
use App\Core\Request;

/**
 * Kullanici giris yapmadiysa /login'e gonderir.
 * routes/web.php'de 'middleware' => 'auth' seklinde uygulanir.
 */
class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('/login'));
            exit;
        }
    }
}
