<?php
/**
 * Home page (v4 mockup entegrasyonu).
 * Controller'dan gelen degiskenler:
 *   $stats        - ['institutions' => n, 'vehicles' => n, 'services' => n, 'daily_passengers' => n]
 *   $references   - Institution array'i (en fazla 7 tane gosterilecek)
 *   $fleetTotals  - ['sprinter' => n, 'midibus' => n, 'otobus' => n, 'vip' => n]
 *   $company      - settings tablosundan
 */
$stats       = $stats       ?? ['institutions'=>0,'vehicles'=>0,'services'=>0,'daily_passengers'=>0];
$references  = $references  ?? [];
$fleetTotals = $fleetTotals ?? ['sprinter'=>0,'midibus'=>0,'otobus'=>0,'vip'=>0];
// $foundedYear ve $yearsInBiz PublicController::baseData() tarafindan set edilir
$foundedYear = $foundedYear ?? 2003;
$yearsInBiz  = $yearsInBiz  ?? ((int) date('Y') - $foundedYear);

// Kurum tipine gore rozet metni + kisa aciklama
$typeLabelMap = [
    'Okul'   => 'Öğrenci',
    'Sirket' => 'Personel',
    'Acente' => 'Personel',
    'Diger'  => 'Personel',
];
// Placeholder yorum + rakamlar (case_studies tablosu olmadigi icin sabit)
$placeholderQuotes = [
    'Bir kez olsun geciken personel görmedik.',
    'Velileri arayan tek servis firmasıyız.',
    'Kampüs–şehir hattımızın standardı.',
    '7/24 vardiya sürücüsü — muazzam.',
    'Her sabah tam vaktinde. Rehber refakati artı.',
    'İki ilçe arası hattımızda kesintisiz servis.',
    'OSB hattımızın omurgası, üç fabrika tek koordinasyon.',
];
?>

<!-- ============ HERO ============ -->
<section class="hero">
    <div class="hero-media"></div>
    <div class="hero-photo-hint"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdig9kEMK8pibWDY7osINdz3mFMn1jNzehUD2zw_ECickgPa6wnb9VLGk&s=10" alt=""></div>

    <div class="wrap hero-content">
        <div class="badge-live">
            <span class="dot-live"></span>
            <span>Şu an yolda: <?= max(0, (int)$stats['vehicles'] - 13) ?> araç · Günlük yolcu: <?= number_format($stats['daily_passengers'], 0, ',', '.') ?></span>
        </div>

        <h1>Sabah 06:30'da <span class="accent">tam vaktinde</span> kapınızda.</h1>

        <p class="lede">
            Personel ve öğrenci taşımacılığında Şanlıurfa'nın güvendiği isim.
            <?= (int) $yearsInBiz ?> yıldır aynı saat, aynı sorumluluk.
        </p>

        <div class="hero-actions">
            <a class="btn btn-indigo btn-lg" href="<?= url('/teklif-al') ?>">Anlık teklif al →</a>
            <a class="link-play" href="#">
                <span class="play-icon">▶</span>
                <span>Bizi 2 dakikada tanıyın</span>
            </a>
        </div>
    </div>
</section>

<!-- ============ STAT GLASS (overlap) ============ -->
<div class="wrap">
    <div class="stat-glass">
        <div class="stat-item">
            <div class="stat-num"><?= (int) $stats['vehicles'] ?><span class="plus">+</span></div>
            <div class="stat-label">Araç Filosu</div>
        </div>
        <div class="stat-item">
            <div class="stat-num"><?= number_format($stats['daily_passengers'], 0, ',', '.') ?></div>
            <div class="stat-label">Günlük Yolcu</div>
        </div>
        <div class="stat-item">
            <div class="stat-num"><?= (int) $stats['institutions'] ?></div>
            <div class="stat-label">Kurumsal Partner</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">%99.8</div>
            <div class="stat-label">Zamanında Servis</div>
        </div>
    </div>
</div>

<!-- ============ HİZMETLER — Sticky Storyboard ============ -->
<section class="block reveal">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Ne yapıyoruz</div>
            <h2 class="title">Üç ana hizmet. Aynı sorumlulukla.</h2>
            <p class="section-lede">Aşağı scroll'layın — her hizmet ekrandan geçtikçe soldaki görsel değişecek. Her birinin kendine özel sözleşmesi, filosu, sürücü kadrosu var.</p>
        </div>

        <div class="storyboard">
            <div class="story-media" data-active="1">
                <div class="story-glow"></div>
                <div class="story-title">
                    Personel<br>Servisi
                    <em>Fabrika, ofis ve OSB için.</em>
                </div>
            </div>

            <div class="story-list">
                <article class="story-item on" data-idx="1">
                    <div>
                        <div class="num-top">01 · Kurumlara</div>
                        <h3>Personel Servisi</h3>
                        <p>Fabrika, ofis ve organize sanayi bölgeleri için sabah-akşam düzenli servis. Sözleşmeli, GPS'li, aylık raporlu. <?= (int) $stats['institutions'] ?> kurumsal partner bize güveniyor.</p>
                    </div>
                    <div>
                        <div class="chip-row">
                            <span class="chip">Sözleşmeli</span>
                            <span class="chip">GPS takip</span>
                            <span class="chip">Aylık rapor</span>
                            <span class="chip">SRC belgeli sürücü</span>
                        </div>
                        <a class="arrow-link" href="<?= url('/hizmetlerimiz') ?>">Detaya git →</a>
                    </div>
                </article>

                <article class="story-item" data-idx="2">
                    <div>
                        <div class="num-top">02 · Okullara</div>
                        <h3>Öğrenci Servisi</h3>
                        <p>Rehber refakatinde, MEB standardında öğrenci servisi. Veli takip uygulaması ve kamera kaydı standart hizmet parçasıdır. Anasınıfından liseye tüm yaş grupları.</p>
                    </div>
                    <div>
                        <div class="chip-row">
                            <span class="chip">Rehberli</span>
                            <span class="chip">MEB onaylı</span>
                            <span class="chip">Kamera kayıtlı</span>
                            <span class="chip">Veli takip app</span>
                        </div>
                        <a class="arrow-link" href="<?= url('/hizmetlerimiz') ?>">Detaya git →</a>
                    </div>
                </article>

                <article class="story-item" data-idx="3">
                    <div>
                        <div class="num-top">03 · Özel</div>
                        <h3>Tur & Transfer</h3>
                        <p>Grup gezileri, havalimanı transferi, düğün ve organizasyon taşıma. VIP van'dan otobüse tam yelpaze. 7/24 çalışan koordinatör hattı.</p>
                    </div>
                    <div>
                        <div class="chip-row">
                            <span class="chip">7/24 hizmet</span>
                            <span class="chip">VIP Van</span>
                            <span class="chip">Havalimanı</span>
                            <span class="chip">Kurumsal etkinlik</span>
                        </div>
                        <a class="arrow-link" href="<?= url('/hizmetlerimiz') ?>">Detaya git →</a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- ============ FİLO — Bento büyük foto ============ -->
<section class="block reveal" style="background:var(--bg-2)">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Filo</div>
            <h2 class="title"><?= (int) $stats['vehicles'] ?> araç. Her biri kayıtlı,<br>her biri bakımlı.</h2>
            <p class="section-lede">GPS takipli, kamera kayıtlı, SRC belgeli sürücülerle çalışan tam donanımlı filo. Tüm araçları ve teknik özelliklerini filo sayfasında inceleyebilirsiniz.</p>
        </div>

        <div class="fleet-bento">
            <div class="big-photo">
                <div class="top-fill"></div>
                <div class="b-bottom">
                    <h3><?= (int) $stats['vehicles'] ?> araçlık filo.</h3>
                    <p>Ortalama araç yaşı 4. GPS takipli, kamera kayıtlı, tamamı ruhsatlı ve sigortalı.</p>
                    <a class="link-inline" href="<?= url('/filo') ?>">Tüm filoyu incele →</a>
                </div>
            </div>

            <div class="side">
                <span class="badge-corner pop">Popüler</span>
                <div><div class="num-big"><?= (int) $fleetTotals['sprinter'] ?><span class="arac">araç</span></div></div>
                <div>
                    <div class="type-name">Sprinter</div>
                    <div class="type-cap">14–19 kişilik</div>
                </div>
            </div>

            <div class="side">
                <div><div class="num-big"><?= (int) $fleetTotals['midibus'] ?><span class="arac">araç</span></div></div>
                <div>
                    <div class="type-name">Midibüs</div>
                    <div class="type-cap">26–35 kişilik</div>
                </div>
            </div>

            <div class="side">
                <div><div class="num-big"><?= (int) $fleetTotals['otobus'] ?><span class="arac">araç</span></div></div>
                <div>
                    <div class="type-name">Otobüs</div>
                    <div class="type-cap">40–46 kişilik</div>
                </div>
            </div>

            <div class="side">
                <span class="badge-corner prem">Premium</span>
                <div><div class="num-big"><?= (int) $fleetTotals['vip'] ?><span class="arac">araç</span></div></div>
                <div>
                    <div class="type-name">VIP Van</div>
                    <div class="type-cap">8 kişilik</div>
                </div>
            </div>
        </div>

        <div class="fleet-note">
            <i>Her araç</i> GPS'li · <i>Her sürücü</i> SRC belgeli, psikoteknik onaylı · <i>Ortalama yaş</i> 4 yıl
        </div>
    </div>
</section>

<!-- ============ REFERANSLAR — 3D Flip ============ -->
<section class="block reveal">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Referanslar</div>
            <h2 class="title">Güvenlerini bize verenler.</h2>
            <p class="section-lede"><?= (int) $stats['institutions'] ?> kurumla kesintisiz çalışıyoruz. Karta hover edin — arkasında müşteri yorumu ve rakamlar var.</p>
        </div>

        <div class="flip-grid">
            <?php
            $refCount = count($references);
            $show = array_slice($references, 0, 7);
            foreach ($show as $i => $ref):
                $initials = mb_strtoupper(mb_substr(preg_replace('/[^\p{L}]/u', '', $ref['institution_name']), 0, 2, 'UTF-8'), 'UTF-8');
                $typeLabel = $typeLabelMap[$ref['type'] ?? 'Diger'] ?? 'Kurum';
                $quote = $placeholderQuotes[$i % count($placeholderQuotes)];
                // Placeholder yıl/kişi: sonra case_studies tablosundan gelir
                $years = 3 + ($i * 2);
                $daily = 60 + ($i * 40);
                $vehs  = 3 + $i;
            ?>
            <div class="flip-card">
                <div class="flip-inner">
                    <div class="flip-face flip-front">
                        <div class="mark"><?= e($initials ?: 'K') ?></div>
                        <span class="hint">↺ Çevir</span>
                        <div>
                            <div class="name"><?= e($ref['institution_name']) ?></div>
                            <div class="type"><?= e($typeLabel) ?> · <?= e($ref['type'] ?? '') ?></div>
                        </div>
                    </div>
                    <div class="flip-face flip-back">
                        <div class="quote"><?= e($quote) ?></div>
                        <div class="stat-row">
                            <div class="stat"><div class="stat-num"><?= (int) $years ?></div><div class="stat-label">Yıldır</div></div>
                            <div class="stat"><div class="stat-num"><?= (int) $daily ?></div><div class="stat-label">Kişi/gün</div></div>
                            <div class="stat"><div class="stat-num"><?= (int) $vehs ?></div><div class="stat-label">Araç</div></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php // Bos kart sayisi 8'e tamamlanmasi icin placeholder
            $emptySlots = max(0, 7 - count($show));
            for ($k = 0; $k < $emptySlots; $k++): ?>
            <div class="flip-card">
                <div class="flip-inner">
                    <div class="flip-face flip-front" style="background:var(--bg-2);border-style:dashed">
                        <div class="mark" style="background:#fff;color:var(--muted-2)">?</div>
                        <div>
                            <div class="name" style="color:var(--muted-2)">Boş slot</div>
                            <div class="type">Admin'den kurum ekle</div>
                        </div>
                    </div>
                    <div class="flip-face flip-back"><div class="quote">Yeni referans eklenince burada görünür.</div></div>
                </div>
            </div>
            <?php endfor; ?>

            <!-- Son kart: +N Diger -->
            <div class="flip-card">
                <div class="flip-inner">
                    <div class="flip-face flip-front">
                        <div class="mark">+<?= max(0, (int) $stats['institutions'] - 7) ?></div>
                        <span class="hint">↺ Çevir</span>
                        <div>
                            <div class="name">Diğer kurumlar</div>
                            <div class="type">Tüm liste referanslar sayfasında</div>
                        </div>
                    </div>
                    <div class="flip-face flip-back" style="background:linear-gradient(135deg,#0b1220,#1a2338)">
                        <div class="quote" style="font-style:normal;color:#fff;font-size:15px;font-weight:600"><?= (int) $stats['institutions'] ?> kurum, <?= number_format($stats['daily_passengers'], 0, ',', '.') ?> günlük yolcu.</div>
                        <div class="stat-row" style="border-color:rgba(255,255,255,.15)">
                            <a href="<?= url('/referanslarimiz') ?>" style="color:#fdba74;font-size:13px;font-weight:500;display:inline-flex;align-items:center;gap:6px">Tümünü gör →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="flip-hint-line"><i>↺</i> Kartların üzerine gelin — arkasında yorum + rakamlar</p>
    </div>
</section>

<!-- ============ FAQ ============ -->
<section class="block reveal" style="background:var(--bg-2)" id="faq">
    <div class="wrap">
        <div class="section-head" style="text-align:center;margin-left:auto;margin-right:auto">
            <div class="eyebrow">Sıkça sorulanlar</div>
            <h2 class="title">Aklınıza takılanlar.</h2>
        </div>

        <div class="faq-wrap">
            <details class="faq" open>
                <summary>Servisim gecikirse ne olur?</summary>
                <div class="faq-body">Her aracımızda GPS var; gecikme anında koordinatörümüz kurum yetkilisini arar. Ortalama gecikme süremiz aylık 2 dakikanın altındadır; %99.8 zamanında servis oranını burada tutuyoruz.</div>
            </details>
            <details class="faq">
                <summary>Sigortalar dahil mi?</summary>
                <div class="faq-body">Trafik sigortası, koltuk sigortası ve mesleki sorumluluk sigortası tamamı fiyata dahildir. Sözleşme öncesi belgelerini paylaşırız.</div>
            </details>
            <details class="faq">
                <summary>Sözleşme minimum ne kadar?</summary>
                <div class="faq-body">Personel servisi için minimum 3 aylık sözleşme yapıyoruz. Öğrenci servisi eğitim-öğretim yılı boyu (Eylül–Haziran). Tur/transfer için sözleşme gerekmez.</div>
            </details>
            <details class="faq">
                <summary>Rotamız listenizde yok, hat açabilir misiniz?</summary>
                <div class="faq-body">15+ yolcu için özel hat kuruyoruz. Rota fizibilitesini 24 saat içinde çıkarıp size dönüyoruz.</div>
            </details>
            <details class="faq">
                <summary>Aracın bakımı sırasında ne oluyor?</summary>
                <div class="faq-body">Filomuzda her tipte yedek araç bulunuyor; planlı bakım sırasında hizmet aksamaz. Arıza durumunda 30 dakika içinde yedek aracımız güzergâha girer.</div>
            </details>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<?php
$c = $company ?? [];
$phone = $c['contact_phone'] ?? '+90 414 000 00 00';
$phoneClean = preg_replace('/\D/', '', $phone);
?>
<section class="cta-outer reveal">
    <div class="wrap">
        <div class="cta-glass">
            <div>
                <h2>Kurumunuz için özel teklif —<br>bir saat içinde dönelim.</h2>
                <p>Güzergâhınızı ve personel sayınızı iletin; size en uygun aracı ve fiyatı hesaplayalım.</p>
            </div>
            <div class="cta-glass-actions">
                <a class="btn btn-indigo btn-lg" href="<?= url('/teklif-al') ?>">Anlık teklif hesapla →</a>
                <a class="cta-phone" href="tel:<?= e($phoneClean) ?>">
                    <span>Ya da direkt arayın:</span>
                    <span class="num"><?= e($phone) ?></span>
                </a>
            </div>
        </div>
    </div>
</section>
