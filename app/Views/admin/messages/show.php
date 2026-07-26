<?php
/** @var array $msg */
/** @var array|null $formData */

$sourceLabel = ['contact' => 'İletişim Formu', 'quote' => 'Teklif Talebi'][$msg['source']] ?? 'Diger';
$sourceBg    = ['contact' => '#e0e7ff',         'quote' => '#ffedd5'][$msg['source']]    ?? '#f1f5f9';
$sourceColor = ['contact' => '#4338ca',         'quote' => '#c2410c'][$msg['source']]    ?? '#475569';

// Teklif form_data icin okunakli etiket haritasi
$formDataLabels = [
    'service'      => 'Hizmet Tipi',
    'from'         => 'Nereden',
    'to'           => 'Nereye',
    'people'       => 'Kişi Sayısı',
    'frequency'    => 'Kullanım',
    'duration'     => 'Süre',
    'addon_guide'  => 'Rehber Refakati',
    'addon_report' => 'Aylık Raporlama',
    'addon_backup' => 'Yedek Araç',
    'addon_vip'    => 'VIP Yükseltme',
    'note'         => 'Not',
];
$freqDisplay = ['both' => 'Sabah + Akşam', 'one' => 'Tek yön', 'shift' => '3 vardiya'];
$durDisplay  = ['3' => '3 ay', '6' => '6 ay', '12' => '12 ay', 'edu' => 'Eğitim yılı', 'once' => 'Tek seferlik'];
$svcDisplay  = ['personel' => 'Personel Servisi', 'ogrenci' => 'Öğrenci Servisi', 'tur' => 'Tur & Transfer'];

function fd_val(string $key, $val, array $freqDisplay, array $durDisplay, array $svcDisplay): string {
    if ($val === '1') return 'Evet ✓';
    if ($val === '0' || $val === '' || $val === null) return '-';
    if ($key === 'service')   return $svcDisplay[$val]  ?? $val;
    if ($key === 'frequency') return $freqDisplay[$val] ?? $val;
    if ($key === 'duration')  return $durDisplay[$val]  ?? $val;
    return (string) $val;
}

$phoneClean = preg_replace('/\D/', '', $msg['phone']);
$waNum = $phoneClean;
if (!empty($waNum) && str_starts_with($waNum, '0')) $waNum = '90' . substr($waNum, 1);
?>
<header class="top-header">
    <div class="header-title">
        <h1>Mesaj Detayı</h1>
        <p>Gelen mesajı okuyup müşteriye yanıt için hızlı iletişim düğmelerini kullanabilirsin.</p>
    </div>
    <div class="header-action">
        <a href="<?= url('/admin/messages') ?>" class="btn-primary" style="background:#fff; color:var(--metin-koyu); border:1px solid var(--border-color); box-shadow:none;">
            <i class="fas fa-arrow-left"></i> Listeye Dön
        </a>
    </div>
</header>

<?php if ($m = flash('success')): ?>
    <div class="alert alert-success"><?= e($m) ?></div>
<?php endif; ?>

<div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px;">

    <!-- SOL: Mesaj icerigi -->
    <div class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <i class="fas fa-envelope-open-text"></i>
                <div>
                    <h3>Mesaj İçeriği</h3>
                    <p><?= e($msg['subject'] ?: '(Konu belirtilmemis)') ?></p>
                </div>
                <span class="badge" style="background-color:<?= $sourceBg ?>; color:<?= $sourceColor ?>; margin-left:auto;">
                    <?= e($sourceLabel) ?>
                </span>
            </div>
        </div>
        <div class="panel-body">
            <?php if (!empty($msg['message'])): ?>
                <div style="background:#fafbfc; border:1px solid var(--border-color); border-radius:12px; padding:20px; color:#334155; font-size:14.5px; line-height:1.7; white-space:pre-wrap;"><?= e($msg['message']) ?></div>
            <?php else: ?>
                <div style="color:#94a3b8; font-style:italic;">Mesaj metni boş bırakılmış.</div>
            <?php endif; ?>

            <?php if (!empty($formData)): ?>
                <h4 style="margin-top:24px; margin-bottom:12px; font-size:13px; color:#64748b; text-transform:uppercase; letter-spacing:.08em; font-weight:600;">
                    Form Detayları
                </h4>
                <table style="width:100%; border-collapse:collapse; font-size:13.5px;">
                    <?php foreach ($formDataLabels as $key => $label):
                        if (!array_key_exists($key, $formData)) continue;
                        $val = fd_val($key, $formData[$key], $freqDisplay, $durDisplay, $svcDisplay);
                    ?>
                    <tr>
                        <td style="padding:10px 14px; background:#f8fafc; width:180px; color:#64748b; font-weight:500; border-bottom:1px solid #f1f5f9;">
                            <?= e($label) ?>
                        </td>
                        <td style="padding:10px 14px; color:#0f172a; font-weight:500; border-bottom:1px solid #f1f5f9;">
                            <?= e($val) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- SAG: Gonderen + hizli iletisim -->
    <div>
        <div class="panel" style="margin-bottom:20px;">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-user"></i>
                    <div>
                        <h3>Gönderen</h3>
                        <p>İletişim bilgileri</p>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div style="margin-bottom:14px;">
                    <div style="font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em; font-weight:600; margin-bottom:4px;">Ad Soyad</div>
                    <div style="font-size:16px; color:#0f172a; font-weight:600;"><?= e($msg['name']) ?></div>
                </div>
                <?php if (!empty($msg['company'])): ?>
                <div style="margin-bottom:14px;">
                    <div style="font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em; font-weight:600; margin-bottom:4px;">Kurum</div>
                    <div style="font-size:14px; color:#334155;"><?= e($msg['company']) ?></div>
                </div>
                <?php endif; ?>
                <div style="margin-bottom:14px;">
                    <div style="font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em; font-weight:600; margin-bottom:4px;">Telefon</div>
                    <div style="font-family:monospace; font-size:14px; color:#0f172a;"><?= e($msg['phone']) ?></div>
                </div>
                <?php if (!empty($msg['email'])): ?>
                <div style="margin-bottom:14px;">
                    <div style="font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em; font-weight:600; margin-bottom:4px;">E-posta</div>
                    <div style="font-size:13.5px; color:#4f46e5; word-break:break-all;"><?= e($msg['email']) ?></div>
                </div>
                <?php endif; ?>
                <div>
                    <div style="font-size:11px; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em; font-weight:600; margin-bottom:4px;">Geliş Zamanı</div>
                    <div style="font-size:13px; color:#334155;">
                        <?= e(date('d.m.Y H:i', strtotime($msg['created_at']))) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hizli iletisim aksiyonlari -->
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="fas fa-bolt"></i>
                    <div>
                        <h3>Hızlı Yanıt</h3>
                        <p>Bir tıkla iletişime geç</p>
                    </div>
                </div>
            </div>
            <div class="panel-body" style="display:flex; flex-direction:column; gap:10px;">
                <a href="tel:<?= e($phoneClean) ?>" class="btn-submit btn-submit-blue" style="text-decoration:none; margin-top:0;">
                    <i class="fas fa-phone"></i> Ara: <?= e($msg['phone']) ?>
                </a>
                <a href="https://wa.me/<?= e($waNum) ?>" target="_blank" class="btn-submit" style="text-decoration:none; margin-top:0; background:#25D366;">
                    <i class="fab fa-whatsapp"></i> WhatsApp'tan Yaz
                </a>
                <?php if (!empty($msg['email'])): ?>
                <a href="mailto:<?= e($msg['email']) ?>" class="btn-submit" style="text-decoration:none; margin-top:0; background:#fff; color:#0f172a; border:1px solid var(--border-color); box-shadow:none;">
                    <i class="fas fa-envelope"></i> E-posta Yaz
                </a>
                <?php endif; ?>
                <a href="<?= url('/admin/messages/' . (int) $msg['id'] . '/delete') ?>"
                   class="btn-submit delete-alert-btn"
                   data-confirm-text="Mesaji silmek uzeresin."
                   style="text-decoration:none; margin-top:8px; background:#fff; color:#dc2626; border:1px solid #fee2e2; box-shadow:none;">
                    <i class="fas fa-trash"></i> Mesajı Sil
                </a>
            </div>
        </div>
    </div>
</div>
