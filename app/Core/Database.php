<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * Database: PDO baglantisini uretir.
 * Ayarlar config/database.php'den, o da .env'den okur.
 *
 * Kullanim (Model icinde):
 *   $db = Database::connection();
 *   $stmt = $db->prepare("SELECT * FROM institutions");
 *   $stmt->execute();
 *
 * NOT: Baglanti "singleton" tutulur -> ayni istek icinde bir kere kurulur,
 * tekrar cagirildiginda ayni PDO nesnesi doner. Performans + kod sadeligi.
 */
class Database
{
    private static ?PDO $conn = null;

    public static function connection(): PDO
    {
        if (self::$conn !== null) {
            return self::$conn;
        }

        $config = require App::$basePath . '/config/database.php';

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['database'],
            $config['charset']
        );

        try {
            self::$conn = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            // Debug modunda hatayi gorelim, uretimde generic 500
            if (env('APP_DEBUG', false)) {
                throw $e;
            }
            http_response_code(500);
            exit('Veritabani baglantisi kurulamadi.');
        }

        return self::$conn;
    }
}
