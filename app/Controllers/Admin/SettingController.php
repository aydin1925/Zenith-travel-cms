<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\TelegramNotifier;
use App\Models\Setting;

class SettingController extends Controller
{
    public function edit(Request $request): void
    {
        $this->view('admin/settings/index', [
            'settings'   => Setting::get(),
            'activePage' => 'settings',
            'pageTitle'  => 'Zenith | Sistem Ayarlari',
        ], 'layouts/admin');
    }

    public function update(Request $request): void
    {
        Setting::save($request->body);
        flash('success', 'Ayarlar kaydedildi.');
        $this->redirect('/admin/settings');
    }

    /** GET /admin/settings/telegram-test — anlik test mesaji */
    public function telegramTest(Request $request): void
    {
        $token  = env('TELEGRAM_BOT_TOKEN', '');
        $chatId = env('TELEGRAM_CHAT_ID', '');

        if (empty($token) || empty($chatId)) {
            flash('error', 'Telegram konfigurasyonu eksik. .env dosyasindaki TELEGRAM_BOT_TOKEN ve TELEGRAM_CHAT_ID alanlarini doldur.');
            $this->redirect('/admin/settings');
        }

        $ok = TelegramNotifier::send(
            "✅ <b>Zenith Telegram Testi</b>\n" .
            "━━━━━━━━━━━━━━━━━━━━\n" .
            "Bu bir test mesajidir. Bot ve chat baglantisi calisiyor.\n\n" .
            "⏰ " . date('d.m.Y H:i')
        );

        if ($ok) {
            flash('success', 'Test mesaji Telegram\'a gonderildi. Grubu kontrol et.');
        } else {
            flash('error', 'Mesaj gonderilemedi. Token / chat_id dogru mu? PHP error_log\'a bak.');
        }
        $this->redirect('/admin/settings');
    }
}
