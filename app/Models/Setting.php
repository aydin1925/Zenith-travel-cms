<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

/**
 * Tek satirli "sirket profili" ayari.
 * Tablo bosken get() bos array doner (varsayilan olarak view'da bos gorunur).
 * save() upsert davranisir: kayit yoksa INSERT, varsa UPDATE.
 * Public frontend bu tabloyu okuyup footer/iletisim/hakkimizda alanini besleyecek.
 */
class Setting
{
    /** Tek kayit (ya da tum kolonlar bos array) */
    public static function get(): array
    {
        $db = Database::connection();
        $stmt = $db->prepare("SELECT * FROM settings ORDER BY id ASC LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();
        return $row ?: [];
    }

    /**
     * Upsert:
     *   - Hic kayit yoksa INSERT
     *   - Varsa UPDATE (ilk kaydin id'sini kullanir)
     * Bu tabloda her zaman TEK bir kayit olur.
     */
    public static function save(array $data): void
    {
        $db = Database::connection();

        $existing = $db->query("SELECT id FROM settings ORDER BY id ASC LIMIT 1")->fetch();

        $params = [
            ':company_name'     => $data['company_name']     ?? '',
            ':company_category' => $data['company_category'] ?? null,
            ':about_text'       => $data['about_text']       ?? null,
            ':contact_phone'    => $data['contact_phone']    ?? null,
            ':contact_email'    => $data['contact_email']    ?? null,
            ':address'          => $data['address']          ?? null,
            ':map_embed'        => $data['map_embed']        ?? null,
            ':certificates'     => $data['certificates']     ?? null,
            ':logo_url'         => $data['logo_url']         ?? null,
            ':founded_year'     => !empty($data['founded_year']) ? (int) $data['founded_year'] : null,
            ':founder_name'     => $data['founder_name']     ?? null,
            ':founder_role'     => $data['founder_role']     ?? null,
            ':founder_quote'    => $data['founder_quote']    ?? null,
        ];

        if ($existing) {
            $sql = "UPDATE settings SET
                        company_name     = :company_name,
                        company_category = :company_category,
                        about_text       = :about_text,
                        contact_phone    = :contact_phone,
                        contact_email    = :contact_email,
                        address          = :address,
                        map_embed        = :map_embed,
                        certificates     = :certificates,
                        logo_url         = :logo_url,
                        founded_year     = :founded_year,
                        founder_name     = :founder_name,
                        founder_role     = :founder_role,
                        founder_quote    = :founder_quote
                    WHERE id = :id";
            $params[':id'] = (int) $existing['id'];
        } else {
            $sql = "INSERT INTO settings
                    (company_name, company_category, about_text, contact_phone, contact_email,
                     address, map_embed, certificates, logo_url,
                     founded_year, founder_name, founder_role, founder_quote)
                    VALUES
                    (:company_name, :company_category, :about_text, :contact_phone, :contact_email,
                     :address, :map_embed, :certificates, :logo_url,
                     :founded_year, :founder_name, :founder_role, :founder_quote)";
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
    }
}
