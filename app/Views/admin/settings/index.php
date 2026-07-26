<?php
/** @var array $settings */
$s = $settings;
?>
<header class="top-header">
    <div class="header-title">
        <h1>Sistem Ayarlari</h1>
        <p>Sirket profili — buradaki bilgiler public web sitesindeki footer, hakkimizda ve iletisim alanini besler.</p>
    </div>
</header>

<?php if ($msg = flash('success')): ?>
    <div class="alert alert-success"><?= e($msg) ?></div>
<?php endif; ?>

<form action="<?= url('/admin/settings') ?>" method="POST" class="settings-form">

    <!-- ============ SEKME 1: KIMLIK ============ -->
    <section class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <i class="fas fa-building"></i>
                <div>
                    <h3>Sirket Kimligi</h3>
                    <p>Isim, kategori, logo — sitede en cok gorunecek bilgiler.</p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-row">
                <div class="form-group" style="flex:2;">
                    <label>Sirket Adi <span style="color:red;">*</span></label>
                    <input type="text" name="company_name" class="form-control" required
                           value="<?= e($s['company_name'] ?? '') ?>"
                           placeholder="Orn: Sahin Tasimacilik">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Kategori</label>
                    <input type="text" name="company_category" class="form-control"
                           value="<?= e($s['company_category'] ?? '') ?>"
                           placeholder="Orn: Personel & Ogrenci Tasimaciligi">
                </div>
            </div>

            <div class="form-group">
                <label>Logo URL</label>
                <input type="url" name="logo_url" class="form-control"
                       value="<?= e($s['logo_url'] ?? '') ?>"
                       placeholder="https://sirket.com/logo.png">
                <?php if (!empty($s['logo_url'])): ?>
                    <div style="margin-top:8px;">
                        <img src="<?= e($s['logo_url']) ?>" alt="Logo"
                             style="max-height:56px; border-radius:8px; border:1px solid #e2e8f0; padding:4px; background:#fff;">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ============ KURUCU + KURULUŞ ============ -->
    <section class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <i class="fas fa-user-tie"></i>
                <div>
                    <h3>Kurucu & Kuruluş Bilgileri</h3>
                    <p>Hakkımızda sayfasındaki kurucu spotlight'ında ve tüm rakamsal hesaplarda kullanılır.</p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-row">
                <div class="form-group" style="flex:1;">
                    <label>Kuruluş Yılı</label>
                    <input type="number" name="founded_year" class="form-control"
                           min="1900" max="<?= (int) date('Y') ?>"
                           value="<?= e((string) ($s['founded_year'] ?? '')) ?>"
                           placeholder="Orn: 2003">
                </div>
                <div class="form-group" style="flex:2;">
                    <label>Kurucu Adı Soyadı</label>
                    <input type="text" name="founder_name" class="form-control"
                           value="<?= e($s['founder_name'] ?? '') ?>"
                           placeholder="Orn: Ahmet Sahin">
                </div>
                <div class="form-group" style="flex:2;">
                    <label>Ünvan / Rol</label>
                    <input type="text" name="founder_role" class="form-control"
                           value="<?= e($s['founder_role'] ?? '') ?>"
                           placeholder="Orn: Kurucu · Genel Mudur">
                </div>
            </div>

            <div class="form-group">
                <label>Kurucu Alıntısı <span class="hint">(Hakkımızda spotlight'ında büyük italik olarak görünür)</span></label>
                <textarea name="founder_quote" class="form-control" rows="4" style="height:auto; min-height:120px;"
                          placeholder="Orn: Bu is guven isidir. 23 yildir tek isimiz insanlari zamaninda yerine ulastirmak..."><?= e($s['founder_quote'] ?? '') ?></textarea>
            </div>
        </div>
    </section>

    <!-- ============ SEKME 2: HAKKIMIZDA ============ -->
    <section class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <i class="fas fa-align-left"></i>
                <div>
                    <h3>Hakkimizda Metni</h3>
                    <p>Sitedeki "Kimiz ne yapariz" bolumu icin uzun tanitim yazisi.</p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Tanitim yazisi</label>
                <textarea name="about_text" class="form-control" rows="6" style="height:auto; min-height:140px;"
                          placeholder="Sirketinizin kurulus hikayesi, misyonu, degerleri..."><?= e($s['about_text'] ?? '') ?></textarea>
            </div>
        </div>
    </section>

    <!-- ============ SEKME 3: ILETISIM ============ -->
    <section class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <i class="fas fa-phone"></i>
                <div>
                    <h3>Iletisim Bilgileri</h3>
                    <p>Musteriler bu bilgilerle size ulasacak.</p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Telefon</label>
                    <input type="text" name="contact_phone" class="form-control"
                           value="<?= e($s['contact_phone'] ?? '') ?>"
                           placeholder="0 414 000 00 00">
                </div>
                <div class="form-group">
                    <label>E-posta</label>
                    <input type="email" name="contact_email" class="form-control"
                           value="<?= e($s['contact_email'] ?? '') ?>"
                           placeholder="info@sirket.com">
                </div>
            </div>

            <div class="form-group">
                <label>Adres</label>
                <textarea name="address" class="form-control" rows="2" style="height:auto; min-height:70px;"
                          placeholder="Mahalle, cadde, no, ilce/il..."><?= e($s['address'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>Harita Embed Kodu <span class="hint">(Google Maps &rarr; Paylas &rarr; Web sitesine yerlestir &rarr; iframe kodu)</span></label>
                <textarea name="map_embed" class="form-control" rows="3" style="height:auto; min-height:80px; font-family:monospace; font-size:12px;"
                          placeholder='&lt;iframe src="https://www.google.com/maps/embed?..." width="600" height="450"&gt;&lt;/iframe&gt;'><?= e($s['map_embed'] ?? '') ?></textarea>
            </div>
        </div>
    </section>

    <!-- ============ SEKME 4: SERTIFIKALAR ============ -->
    <section class="panel">
        <div class="panel-head">
            <div class="panel-title">
                <i class="fas fa-certificate"></i>
                <div>
                    <h3>Sertifikalar & Belgeler</h3>
                    <p>D2 yetki belgesi, ISO, MEB onayi vb. — her satira bir belge yazin.</p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Belgeler (her satira bir tane)</label>
                <textarea name="certificates" class="form-control" rows="4" style="height:auto; min-height:100px;"
                          placeholder="D2 Yetki Belgesi&#10;ISO 9001:2015&#10;MEB Onayli Servis Firmasi"><?= e($s['certificates'] ?? '') ?></textarea>
            </div>
        </div>
    </section>

    <div class="form-actions">
        <button type="submit" class="btn-submit btn-submit-blue" style="max-width:280px;">
            <i class="fas fa-save"></i> Ayarlari Kaydet
        </button>
    </div>
</form>

<!-- ============ TELEGRAM PANEL (form disinda) ============ -->
<?php
$tgToken  = env('TELEGRAM_BOT_TOKEN', '');
$tgChatId = env('TELEGRAM_CHAT_ID', '');
$tgReady  = !empty($tgToken) && !empty($tgChatId);
?>
<section class="panel" style="margin-top:20px;">
    <div class="panel-head">
        <div class="panel-title">
            <i class="fab fa-telegram" style="color:#0088cc;"></i>
            <div>
                <h3>Telegram Bildirimleri</h3>
                <p>Iletisim ve teklif formlarindan gelen her mesaj Telegram grubuna dusuyor.</p>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?php if ($tgReady): ?>
            <div style="padding:14px 18px; background:#d1fae5; color:#065f46; border-radius:12px; font-size:14px; display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                <i class="fas fa-check-circle" style="color:#10b981; font-size:18px;"></i>
                <div>
                    <div style="font-weight:600;">Bot bagli</div>
                    <div style="font-size:12.5px; color:#047857;">
                        Chat ID: <code style="background:rgba(0,0,0,.05); padding:2px 6px; border-radius:4px;"><?= e($tgChatId) ?></code>
                    </div>
                </div>
            </div>
            <a href="<?= url('/admin/settings/telegram-test') ?>"
               class="btn-primary" style="background:#0088cc; border:0;">
                <i class="fab fa-telegram"></i> Test Mesaji Gonder
            </a>
        <?php else: ?>
            <div style="padding:14px 18px; background:#fef3c7; color:#78350f; border-radius:12px; font-size:14px; display:flex; align-items:flex-start; gap:12px;">
                <i class="fas fa-exclamation-triangle" style="color:#d97706; font-size:18px; margin-top:2px;"></i>
                <div>
                    <div style="font-weight:600; margin-bottom:4px;">Telegram konfigurasyonu eksik</div>
                    <div style="font-size:13px; line-height:1.5;">
                        Proje kokundeki <code style="background:rgba(0,0,0,.05); padding:2px 6px; border-radius:4px;">.env</code> dosyasindaki
                        <code style="background:rgba(0,0,0,.05); padding:2px 6px; border-radius:4px;">TELEGRAM_BOT_TOKEN</code> ve
                        <code style="background:rgba(0,0,0,.05); padding:2px 6px; border-radius:4px;">TELEGRAM_CHAT_ID</code>
                        alanlarini doldurdugunda bildirimler otomatik gonderilmeye baslar.
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
