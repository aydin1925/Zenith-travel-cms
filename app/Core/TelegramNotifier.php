<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Telegram Bot API'ye HTML formatli mesaj gonderir.
 * Konfigurasyon .env icinde:
 *   TELEGRAM_BOT_TOKEN  (BotFather'dan aldigin token)
 *   TELEGRAM_CHAT_ID    (mesajin gidecegi chat/grup id — grup ise "-100..." seklinde)
 *
 * .env bos ise sessiz sekilde no-op eder — site normal calisir, bildirim gitmez.
 */
class TelegramNotifier
{
    private const API = 'https://api.telegram.org/bot';

    /** Ham mesaj gonder (HTML parse mode) */
    public static function send(string $htmlMessage): bool
    {
        $token  = (string) env('TELEGRAM_BOT_TOKEN', '');
        $chatId = (string) env('TELEGRAM_CHAT_ID', '');

        if ($token === '' || $chatId === '') {
            return false; // Konfigurasyon yok — sessiz no-op
        }

        $url = self::API . $token . '/sendMessage';
        $payload = [
            'chat_id'                  => $chatId,
            'text'                     => $htmlMessage,
            'parse_mode'               => 'HTML',
            'disable_web_page_preview' => true,
        ];

        try {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => http_build_query($payload),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 5,
                CURLOPT_CONNECTTIMEOUT => 3,
                CURLOPT_SSL_VERIFYPEER => true,
            ]);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                error_log("Telegram API hatasi ($httpCode): $response");
                return false;
            }
            return true;
        } catch (\Throwable $e) {
            error_log('Telegram gonderim hatasi: ' . $e->getMessage());
            return false;
        }
    }

    /** Iletisim formu mesajlari icin bicim */
    public static function notifyContact(array $msg, int $messageId): bool
    {
        $lines   = [];
        $lines[] = "🔔 <b>Zenith · Yeni İletişim Mesajı</b>";
        $lines[] = "━━━━━━━━━━━━━━━━━━━━";
        $lines[] = "👤 İsim: <b>" . self::esc($msg['name']) . "</b>";
        $lines[] = "📞 Telefon: <code>" . self::esc($msg['phone']) . "</code>";
        if (!empty($msg['email']))   $lines[] = "✉️ email: " . self::esc($msg['email']);
        if (!empty($msg['company'])) $lines[] = "🏢 Şirket: " . self::esc($msg['company']);
        $lines[] = '';
        $lines[] = "📝 <b>Konu:</b> " . self::esc($msg['subject'] ?: 'Belirtilmemis');
        if (!empty($msg['message'])) {
            $lines[] = '';
            $lines[] = self::esc(mb_substr($msg['message'], 0, 500, 'UTF-8')) .
                       (mb_strlen($msg['message'], 'UTF-8') > 500 ? '…' : '');
        }
        $lines[] = '';
        $lines[] = '⏰ ' . date('d.m.Y H:i');
        $lines[] = '🔗 <a href="' . url('/admin/messages/' . $messageId) . '">Admin panelde aç</a>';

        return self::send(implode("\n", $lines));
    }

    /** Teklif talebi mesajlari icin bicim (form_data'yi de detayli goster) */
    public static function notifyQuote(array $msg, array $formData, int $messageId): bool
    {
        $svcLabels = ['personel' => 'Personel Servisi', 'ogrenci' => 'Öğrenci Servisi', 'tur' => 'Tur & Transfer'];
        $freqLabels = ['both' => 'Sabah + Akşam', 'one' => 'Tek yön', 'shift' => '3 vardiya'];
        $durLabels = ['3' => '3 aylık', '6' => '6 aylık', '12' => '12 aylık', 'edu' => 'Eğitim yılı', 'once' => 'Tek seferlik'];

        $addons = [];
        if (($formData['addon_guide']  ?? '0') === '1') $addons[] = 'Rehber';
        if (($formData['addon_report'] ?? '0') === '1') $addons[] = 'Aylık rapor';
        if (($formData['addon_backup'] ?? '0') === '1') $addons[] = 'Yedek araç';
        if (($formData['addon_vip']    ?? '0') === '1') $addons[] = 'VIP yükseltme';

        $lines   = [];
        $lines[] = "💰 <b>Zenith · Yeni Teklif Talebi</b>";
        $lines[] = "━━━━━━━━━━━━━━━━━━━━";
        $lines[] = "👤 <b>" . self::esc($msg['name']) . "</b>";
        $lines[] = "📞 <code>" . self::esc($msg['phone']) . "</code>";
        if (!empty($msg['email']))   $lines[] = "✉️ " . self::esc($msg['email']);
        if (!empty($msg['company'])) $lines[] = "🏢 " . self::esc($msg['company']);
        $lines[] = '';
        $lines[] = "🎯 <b>Hizmet:</b> " . self::esc($svcLabels[$formData['service'] ?? ''] ?? 'Genel');
        if (!empty($formData['from']) && !empty($formData['to'])) {
            $lines[] = "🗺 <b>Güzergâh:</b> " . self::esc($formData['from']) . ' → ' . self::esc($formData['to']);
        }
        if (!empty($formData['people'])) {
            $lines[] = "👥 <b>Kişi sayısı:</b> " . (int) $formData['people'];
        }
        if (!empty($formData['frequency'])) {
            $lines[] = "🕒 <b>Kullanım:</b> " . self::esc($freqLabels[$formData['frequency']] ?? $formData['frequency']);
        }
        if (!empty($formData['duration'])) {
            $lines[] = "📆 <b>Süre:</b> " . self::esc($durLabels[$formData['duration']] ?? $formData['duration']);
        }
        if (!empty($addons)) {
            $lines[] = "✨ <b>Ek hizmetler:</b> " . self::esc(implode(', ', $addons));
        }
        if (!empty($formData['note'])) {
            $lines[] = '';
            $lines[] = "💬 <i>" . self::esc(mb_substr($formData['note'], 0, 300, 'UTF-8')) . "</i>";
        }
        $lines[] = '';
        $lines[] = '⏰ ' . date('d.m.Y H:i');
        $lines[] = '🔗 <a href="' . url('/admin/messages/' . $messageId) . '">Admin panelde aç</a>';

        return self::send(implode("\n", $lines));
    }

    private static function esc(string $s): string
    {
        return htmlspecialchars($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
