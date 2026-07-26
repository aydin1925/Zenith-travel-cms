<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Vehicle
{
    public static function all(): array
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT * FROM vehicles ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT * FROM vehicles WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function count(): int
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM vehicles WHERE status = 'aktif'");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /** Tipe gore arac sayilari — filo sayfasi ve home bento icin */
    public static function countByType(): array
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT type, COUNT(*) AS cnt FROM vehicles WHERE status = 'aktif' GROUP BY type");
        $stmt->execute();
        // Varsayilan sifir doldurulur (tip henuz eklenmedi ise 0 gorunsun)
        $result = ['sprinter' => 0, 'midibus' => 0, 'otobus' => 0, 'vip' => 0];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['type']] = (int) $row['cnt'];
        }
        return $result;
    }

    /** id + plaka listesi (services dropdown'unda kullanilir) */
    public static function options(): array
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT id, plate_number FROM vehicles ORDER BY plate_number ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function create(array $data): void
    {
        $db = Database::connection();
        $sql = "INSERT INTO vehicles
                (brand_model, plate_number, capacity, type, model_year, features, photo_url, status)
                VALUES
                (:brand, :plate, :cap, :type, :year, :features, :photo, :status)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':brand'    => $data['brand_model'],
            ':plate'    => strtoupper(str_replace(' ', '', $data['plate_number'])),
            ':cap'      => $data['capacity']   ?? null,
            ':type'     => $data['type']       ?? 'sprinter',
            ':year'     => !empty($data['model_year']) ? (int) $data['model_year'] : null,
            ':features' => $data['features']   ?? null,
            ':photo'    => $data['photo_url']  ?? null,
            ':status'   => $data['status']     ?? 'aktif',
        ]);
    }

    public static function update(int $id, array $data): void
    {
        $db = Database::connection();
        $sql = "UPDATE vehicles SET
                    brand_model  = :brand,
                    plate_number = :plate,
                    capacity     = :cap,
                    type         = :type,
                    model_year   = :year,
                    features     = :features,
                    photo_url    = :photo,
                    status       = :status
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':brand'    => $data['brand_model'],
            ':plate'    => strtoupper(str_replace(' ', '', $data['plate_number'])),
            ':cap'      => $data['capacity']   ?? null,
            ':type'     => $data['type']       ?? 'sprinter',
            ':year'     => !empty($data['model_year']) ? (int) $data['model_year'] : null,
            ':features' => $data['features']   ?? null,
            ':photo'    => $data['photo_url']  ?? null,
            ':status'   => $data['status']     ?? 'aktif',
            ':id'       => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $db = Database::connection();
        $stmt = $db->prepare("DELETE FROM vehicles WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
