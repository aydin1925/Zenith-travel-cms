<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Institution
{
    /** Tum kurumlar (en yeniden en eskiye) */
    public static function all(): array
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT * FROM institutions ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** id -> tek kurum (yoksa null) */
    public static function find(int $id): ?array
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT * FROM institutions WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** id + institution_name listesi (select dropdown'larinda kullanilir) */
    public static function options(): array
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT id, institution_name FROM institutions ORDER BY institution_name ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Kurum sayisi (dashboard icin) */
    public static function count(): int
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM institutions");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public static function create(array $data): void
    {
        $db = Database::connection();
        $sql = "INSERT INTO institutions
                (institution_name, type, contact_person, phone, email,
                 status, tax_office, tax_number, address, logo_url)
                VALUES
                (:name, :type, :contact, :phone, :email,
                 :status, :tax_office, :tax_number, :address, :logo_url)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':name'       => $data['institution_name'],
            ':type'       => $data['institution_type'],
            ':contact'    => $data['contact_person'],
            ':phone'      => $data['phone'],
            ':email'      => $data['email']      ?? null,
            ':status'     => (int)($data['status'] ?? 1),
            ':tax_office' => $data['tax_office'] ?? null,
            ':tax_number' => $data['tax_number'] ?? null,
            ':address'    => $data['address']    ?? null,
            ':logo_url'   => $data['logo_url']   ?? null,
        ]);
    }

    public static function update(int $id, array $data): void
    {
        $db = Database::connection();
        $sql = "UPDATE institutions SET
                    institution_name = :name,
                    type             = :type,
                    contact_person   = :contact,
                    phone            = :phone,
                    email            = :email,
                    status           = :status,
                    tax_office       = :tax_office,
                    tax_number       = :tax_number,
                    address          = :address,
                    logo_url         = :logo_url
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':name'       => $data['institution_name'],
            ':type'       => $data['institution_type'],
            ':contact'    => $data['contact_person'],
            ':phone'      => $data['phone'],
            ':email'      => $data['email']      ?? null,
            ':status'     => (int)($data['status'] ?? 1),
            ':tax_office' => $data['tax_office'] ?? null,
            ':tax_number' => $data['tax_number'] ?? null,
            ':address'    => $data['address']    ?? null,
            ':logo_url'   => $data['logo_url']   ?? null,
            ':id'         => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $db = Database::connection();
        $stmt = $db->prepare("DELETE FROM institutions WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
