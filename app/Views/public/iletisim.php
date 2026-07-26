<?php
/**
 * İletişim sayfası.
 * $company (nav + footer + iletisim bilgileri)
 */
$c = $company ?? [];
$name  = $c['company_name']    ?? 'Sahin Tasimacilik';
$phone = $c['contact_phone']   ?? '+90 414 000 00 00';
$email = $c['contact_email']   ?? 'info@sahin.com.tr';
$addr  = $c['address']         ?? 'Karaköprü / Şanlıurfa';
$mapEmbed = $c['map_embed']    ?? '';

$phoneClean = preg_replace('/\D/', '', $phone);
$waNum = $phoneClean;
if (!empty($waNum) && str_starts_with($waNum, '0')) $waNum = '90' . substr($waNum, 1);

$successMsg = flash('success');
$errorMsg   = flash('error');

// Mesai saatleri — ilerde settings'e "business_hours" kolonu eklenebilir
$hours = [
    ['Pazartesi',  '08:00 – 18:00', false],
    ['Salı',       '08:00 – 18:00', false],
    ['Çarşamba',   '08:00 – 18:00', false],
    ['Perşembe',   '08:00 – 18:00', false],
    ['Cuma',       '08:00 – 18:00', false],
    ['Cumartesi',  '09:00 – 15:00', false],
    ['Pazar',      'Kapalı',        true],
];
?>

<!-- ============ PAGE HERO ============ -->
<section class="page-hero">
    <div class="wrap">
        <div class="eyebrow-light">
            <span class="year-pill">7/24 acil hat</span>
            <span>Ortalama yanıt: 12 dakika</span>
        </div>
        <h1>Bize ulaşın.<br><span class="accent">Kahvemiz her zaman hazır.</span></h1>
        <p class="sub">Aşağıdaki formu doldurabilir, doğrudan telefondan arayabilir, WhatsApp'tan yazabilir ya da ofise davet edilebilirsiniz. Ne yolla yazarsanız yazın, en geç bir saat içinde dönüyoruz.</p>
    </div>
</section>

<!-- ============ MAIN CONTACT BLOCK ============ -->
<section class="block reveal" id="form">
    <div class="wrap">
        <div class="contact-layout">

            <!-- SOL: iletisim bilgileri -->
            <div class="contact-info">

                <div class="contact-card featured">
                    <div class="contact-icon">🕒</div>
                    <div class="contact-content">
                        <div class="contact-label">Mesai Saatleri</div>
                        <div class="contact-value">Haftanın 6 günü hizmet</div>
                        <div class="contact-hint">Pazar günü ofis kapalı, ancak 7/24 acil hat aktif.</div>
                        <div class="hours-block">
                            <?php foreach ($hours as $h): ?>
                            <div class="hours-row <?= $h[2] ? 'closed' : '' ?>">
                                <span class="day"><?= e($h[0]) ?></span>
                                <span class="time"><?= e($h[1]) ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon g">📞</div>
                    <div class="contact-content">
                        <div class="contact-label">Telefon</div>
                        <div class="contact-value mono">
                            <a href="tel:<?= e($phoneClean) ?>"><?= e($phone) ?></a>
                        </div>
                        <div class="contact-hint">Ofis · Pzt–Cmt · Mesai içi anında bağlanır</div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon wa">💬</div>
                    <div class="contact-content">
                        <div class="contact-label">WhatsApp</div>
                        <div class="contact-value mono">
                            <a href="https://wa.me/<?= e($waNum) ?>" target="_blank" rel="noopener"><?= e($phone) ?></a>
                        </div>
                        <div class="contact-hint">Anlık mesajlaşma · Ortalama yanıt 12 dk</div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon o">✉</div>
                    <div class="contact-content">
                        <div class="contact-label">E-posta</div>
                        <div class="contact-value">
                            <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
                        </div>
                        <div class="contact-hint">Uzun formatlı teklif ve sözleşme talepleri</div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">📍</div>
                    <div class="contact-content">
                        <div class="contact-label">Ofis Adresi</div>
                        <div class="contact-value"><?= e($addr) ?></div>
                        <div class="contact-hint">Ofise geleceklere randevu almanızı öneririz.</div>
                    </div>
                </div>

            </div>

            <!-- SAG: iletisim formu -->
            <div>
                <div class="contact-form-card">
                    <div class="contact-form-head">
                        <h3>Bize yazın</h3>
                        <p>Formu doldurun, en geç bir saat içinde size dönelim.</p>
                    </div>

                    <?php if ($successMsg): ?>
                    <div class="form-flash success">
                        <span class="ico">✓</span>
                        <span><?= e($successMsg) ?></span>
                    </div>
                    <?php elseif ($errorMsg): ?>
                    <div class="form-flash error">
                        <span class="ico">!</span>
                        <span><?= e($errorMsg) ?></span>
                    </div>
                    <?php endif; ?>

                    <form action="<?= url('/iletisim') ?>" method="POST" class="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Ad Soyad <span class="req">*</span></label>
                                <input type="text" name="name" required placeholder="Ör. Ahmet Yılmaz">
                            </div>
                            <div class="form-group">
                                <label>Telefon <span class="req">*</span></label>
                                <input type="tel" name="phone" required placeholder="0 414 000 00 00">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>E-posta</label>
                                <input type="email" name="email" placeholder="mail@sirket.com">
                            </div>
                            <div class="form-group">
                                <label>Kurum</label>
                                <input type="text" name="company" placeholder="Şirket / okul adı">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Konu</label>
                            <select name="subject">
                                <option value="Personel Servisi teklifi">Personel Servisi teklifi</option>
                                <option value="Öğrenci Servisi teklifi">Öğrenci Servisi teklifi</option>
                                <option value="Tur & Transfer">Tur & Transfer</option>
                                <option value="Özel rota talebi">Özel rota talebi</option>
                                <option value="Diğer">Diğer</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Mesajınız</label>
                            <textarea name="message" placeholder="Personel/öğrenci sayısı, güzergâh, saat aralığı gibi bilgileri iletirseniz teklifi hazırlarken zaman kazanırız."></textarea>
                        </div>

                        <div class="contact-form-submit">
                            <a class="btn btn-indigo btn-lg" href="#" onclick="event.preventDefault(); this.closest('form').submit();">Mesajı gönder →</a>
                            <span class="hint">
                                <span class="dot"></span>
                                <span>Ortalama yanıt: 12 dakika</span>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============ MAP ============ -->
<section class="block reveal" style="background:var(--bg-2);padding-top:20px">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Ofis Konumu</div>
            <h2 class="title">Beni haritada bul.</h2>
            <p class="section-lede"><?= e($addr) ?> — trafiğe göre şehir merkezinden 10-15 dakika.</p>
        </div>

        <div class="map-panel">
            <div class="map-head">
                <div>
                    <h3><?= e($name) ?></h3>
                    <p><?= e($addr) ?></p>
                </div>
                <a class="btn btn-ghost" href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($addr) ?>" target="_blank" rel="noopener">Yol tarifi al →</a>
            </div>
            <div class="map-embed">
                <?php if (!empty($mapEmbed)): ?>
                    <?= $mapEmbed /* admin'den iframe kodu geliyor */ ?>
                <?php else: ?>
                    <div class="empty">
                        <i>🗺️</i>
                        <div>Harita henüz ayarlanmamış.<br><small>Admin panelinden Sistem Ayarları → Harita Embed kodunu ekleyin.</small></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick channels ribbon (map altinda) -->
        <div class="quick-channels">
            <a href="https://wa.me/<?= e($waNum) ?>" target="_blank" rel="noopener" class="quick-channel">
                <div class="qc-ico wa">W</div>
                <div class="qc-label">WhatsApp</div>
                <div class="qc-value">Anlık mesaj</div>
            </a>
            <a href="tel:<?= e($phoneClean) ?>" class="quick-channel">
                <div class="qc-ico tel">☎</div>
                <div class="qc-label">Telefon</div>
                <div class="qc-value"><?= e($phone) ?></div>
            </a>
            <a href="mailto:<?= e($email) ?>" class="quick-channel">
                <div class="qc-ico mail">✉</div>
                <div class="qc-label">E-posta</div>
                <div class="qc-value"><?= e($email) ?></div>
            </a>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="cta-outer reveal">
    <div class="wrap">
        <div class="cta-glass">
            <div>
                <h2>Zaten karar verdiyseniz —<br>teklif hesaplayıcısı buyurun.</h2>
                <p>Güzergâhınızı ve personel sayınızı iletin, size özel teklifi hesaplayalım.</p>
            </div>
            <div class="cta-glass-actions">
                <a class="btn btn-indigo btn-lg" href="<?= url('/teklif-al') ?>">Teklif hesaplayıcı →</a>
                <a class="cta-phone" href="tel:<?= e($phoneClean) ?>">
                    <span>Ya da direkt arayın:</span>
                    <span class="num"><?= e($phone) ?></span>
                </a>
            </div>
        </div>
    </div>
</section>
