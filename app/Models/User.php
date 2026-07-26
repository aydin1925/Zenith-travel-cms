<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    /**
     * Kullanici adina gore tek kullanici doner (yoksa null).
     * Login akisi bunu kullanir.
     */
    public static function findByUsername(string $username): ?array
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT * FROM Users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}
