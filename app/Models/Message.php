<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

/**
 * Gelen mesajlar (contact + quote formlari).
 * form_data JSON string olarak ek verileri tutar (teklif formundaki tum secimler gibi).
 */
class Message
{
    /** Tum mesajlar, en yeni ustte */
    public static function all(?string $source = null, ?bool $onlyUnread = null): array
    {
        $db = Database::connection();
        $where = [];
        $params = [];

        if ($source !== null && in_array($source, ['contact', 'quote'], true)) {
            $where[] = 'source = :source';
            $params[':source'] = $source;
        }
        if ($onlyUnread === true) {
            $where[] = 'is_read = 0';
        }

        $sql = 'SELECT * FROM messages';
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY created_at DESC, id DESC';

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $db = Database::connection();
        $stmt = $db->prepare('SELECT * FROM messages WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function unreadCount(): int
    {
        $db = Database::connection();
        $stmt = $db->prepare('SELECT COUNT(*) FROM messages WHERE is_read = 0');
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public static function counts(): array
    {
        $db = Database::connection();
        return [
            'total'   => (int) $db->query('SELECT COUNT(*) FROM messages')->fetchColumn(),
            'unread'  => (int) $db->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn(),
            'contact' => (int) $db->query("SELECT COUNT(*) FROM messages WHERE source = 'contact'")->fetchColumn(),
            'quote'   => (int) $db->query("SELECT COUNT(*) FROM messages WHERE source = 'quote'")->fetchColumn(),
        ];
    }

    /**
     * Yeni mesaj olustur.
     * $data:
     *   source (contact|quote), name, phone, email?, company?, subject?, message?, form_data? (array — JSON'a cevrilir)
     */
    public static function create(array $data): int
    {
        $db = Database::connection();
        $formData = $data['form_data'] ?? null;
        if (is_array($formData)) {
            $formData = json_encode($formData, JSON_UNESCAPED_UNICODE);
        }

        $sql = 'INSERT INTO messages
                (source, name, phone, email, company, subject, message, form_data)
                VALUES
                (:source, :name, :phone, :email, :company, :subject, :message, :form_data)';
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':source'    => $data['source']  ?? 'contact',
            ':name'      => $data['name'],
            ':phone'     => $data['phone'],
            ':email'     => $data['email']   ?? null,
            ':company'   => $data['company'] ?? null,
            ':subject'   => $data['subject'] ?? null,
            ':message'   => $data['message'] ?? null,
            ':form_data' => $formData,
        ]);
        return (int) $db->lastInsertId();
    }

    public static function markRead(int $id, bool $read = true): void
    {
        $db = Database::connection();
        $stmt = $db->prepare('UPDATE messages SET is_read = :r WHERE id = :id');
        $stmt->execute([':r' => $read ? 1 : 0, ':id' => $id]);
    }

    public static function delete(int $id): void
    {
        $db = Database::connection();
        $stmt = $db->prepare('DELETE FROM messages WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
