<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Service
{
    /** Kurum + arac JOIN'li tam liste (services ekranindaki tablo icin) */
    public static function allWithRelations(): array
    {
        $db = Database::connection();
        $sql = "SELECT services.*,
                       institutions.institution_name AS institution_name,
                       vehicles.plate_number         AS vehicle_plate
                FROM services
                LEFT JOIN institutions ON services.institution_id = institutions.id
                LEFT JOIN vehicles     ON services.vehicle_id     = vehicles.id
                ORDER BY services.id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function count(): int
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM services");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public static function create(array $data): void
    {
        $db = Database::connection();
        $sql = "INSERT INTO services (service_title, service_type, institution_id, vehicle_id, price, description)
                VALUES (:title, :type, :inst, :veh, :price, :desc)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':title' => $data['service_title'],
            ':type'  => $data['service_type'],
            ':inst'  => (int) $data['institution_id'],
            ':veh'   => (int) $data['vehicle_id'],
            ':price' => $data['price'],
            ':desc'  => $data['description'] ?? null,
        ]);
    }

    public static function update(int $id, array $data): void
    {
        $db = Database::connection();
        $sql = "UPDATE services
                SET service_title  = :title,
                    service_type   = :type,
                    institution_id = :inst,
                    vehicle_id     = :veh,
                    price          = :price,
                    description    = :desc
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':title' => $data['service_title'],
            ':type'  => $data['service_type'],
            ':inst'  => (int) $data['institution_id'],
            ':veh'   => (int) $data['vehicle_id'],
            ':price' => $data['price'],
            ':desc'  => $data['description'] ?? null,
            ':id'    => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $db = Database::connection();
        $stmt = $db->prepare("DELETE FROM services WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
