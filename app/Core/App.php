<?php
declare(strict_types=1);

namespace App\Core;

use Dotenv\Dotenv;

/**
 * App: uygulamanın "boot" (baslatma) surecini yonetir.
 * public/index.php buradaki boot()'u tek satirla cagirir.
 */
class App
{
    public static string $basePath = '';

    public static function boot(string $basePath): void
    {
        self::$basePath = $basePath;

        // 1) .env dosyasini oku ve $_ENV / getenv()'e yukle
        //    Bu sayede DB sifresi gibi hassas veriyi koda yazmiyoruz.
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->safeLoad(); // safeLoad = .env yoksa exception atma

        // 2) Hata modunu env'e gore ayarla
        $debug = filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOL);
        if ($debug) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        } else {
            error_reporting(0);
            ini_set('display_errors', '0');
        }

        // 3) Session'i baslat (henuz baslatilmadiysa)
        //    Auth kontrollerimiz $_SESSION'a bakiyor, o yuzden burada aciyoruz.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 4) Turkce zaman dilimi
        date_default_timezone_set('Europe/Istanbul');
    }
}
