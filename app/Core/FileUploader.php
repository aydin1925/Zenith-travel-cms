<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Basit fotoğraf upload helper'i.
 * - Sadece image (jpg/png/webp/gif)
 * - Max 2 MB
 * - Guvenli dosya adi (rastgele + orijinal uzanti)
 * - Dosya public/uploads/{subfolder}/ altina yazilir
 * - Basarili ise 'uploads/{subfolder}/{filename}' (public'e goreli path) doner
 */
class FileUploader
{
    private const MAX_SIZE = 2 * 1024 * 1024; // 2 MB
    private const ALLOWED_MIMES = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];

    /**
     * $file: $_FILES['field_name'] array'i
     * $subfolder: public/uploads/ altindaki hedef klasor ('institutions', 'vehicles' gibi)
     *
     * Basarili ise: 'uploads/institutions/abcd1234.jpg' seklinde relative path
     * Basarisiz ise: null
     */
    public static function uploadImage(array $file, string $subfolder): ?string
    {
        // Upload edilmis mi
        if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \RuntimeException(self::errorMessage($file['error']));
        }

        // Boyut kontrol
        if ($file['size'] > self::MAX_SIZE) {
            throw new \RuntimeException('Dosya boyutu 2 MB\'i asamaz.');
        }

        // MIME kontrol (finfo ile — extension'a guvenmiyoruz)
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if (!isset(self::ALLOWED_MIMES[$mime])) {
            throw new \RuntimeException('Sadece JPG, PNG, WEBP veya GIF yukleyebilirsin.');
        }

        // Hedef klasor
        $targetDir = App::$basePath . '/public/uploads/' . trim($subfolder, '/');
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }

        // Guvenli dosya adi
        $ext = self::ALLOWED_MIMES[$mime];
        $filename = bin2hex(random_bytes(8)) . '_' . time() . '.' . $ext;
        $target = $targetDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $target)) {
            throw new \RuntimeException('Dosya kaydedilemedi.');
        }

        return 'uploads/' . trim($subfolder, '/') . '/' . $filename;
    }

    /** Public'e goreli path'i tam URL'e cevir (view'da <img src=...> icin) */
    public static function url(?string $path): string
    {
        if (empty($path)) return '';
        // Legacy external URL'ler oldugu gibi kullanilsin
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return url('/' . ltrim($path, '/'));
    }

    /** Silme: kayit silinirken dosyayi da temizle */
    public static function delete(?string $path): void
    {
        if (empty($path)) return;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return;
        $full = App::$basePath . '/public/' . ltrim($path, '/');
        if (is_file($full)) @unlink($full);
    }

    private static function errorMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Dosya cok buyuk (max 2 MB).',
            UPLOAD_ERR_PARTIAL   => 'Dosya kismen yuklendi, tekrar dene.',
            UPLOAD_ERR_NO_FILE   => 'Dosya secilmedi.',
            UPLOAD_ERR_NO_TMP_DIR => 'Sunucu upload icin geciciok klasor bulamadi.',
            UPLOAD_ERR_CANT_WRITE => 'Diske yazilamadi.',
            UPLOAD_ERR_EXTENSION => 'Yukleme bir PHP eklentisi tarafindan durduruldu.',
            default              => 'Bilinmeyen upload hatasi.',
        };
    }
}
