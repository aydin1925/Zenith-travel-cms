<?php
/**
 * Hizmetlerimiz sayfası.
 * $stats (institutions, vehicles), $company
 */
$c = $company ?? [];
?>

<!-- ============ PAGE HERO ============ -->
<section class="page-hero">
    <div class="wrap">
        <div class="eyebrow-light">
            <span class="year-pill">3 ana hizmet</span>
            <span>Personel · Öğrenci · Tur & Transfer</span>
        </div>
        <h1>Üç ana hizmet.<br><span class="accent">Üçünü de aynı</span> ciddiyetle.</h1>
        <p class="sub"><?= (int) $stats['institutions'] ?> kurumsal partner, <?= (int) $stats['vehicles'] ?> araçlık filo. Her hizmetin kendi sözleşmesi, kendi kadrosu, kendi standartları var — ama hepsinde tek bir söz: zamanında ve güvenle.</p>
    </div>
</section>

<!-- ============ SERVICE 1 — PERSONEL ============ -->
<section class="block reveal">
    <div class="wrap">
        <div class="service-detail">
            <div class="service-media indigo">
                <div class="big-num">
                    <?= (int) $stats['institutions'] ?><em>Kurumsal Partner</em>
                </div>
            </div>
            <div class="service-content">
                <div class="eyebrow-num">01 · Kurumlara</div>
                <h2>Personel Servisi</h2>
                <p class="lead">Fabrika, ofis ve organize sanayi bölgeleri için sabah-akşam düzenli servis. Sözleşmeli, GPS'li, aylık raporlu — kurumsal İK süreçlerinize entegre çalışırız.</p>

                <div class="service-checklist">
                    <div class="service-check">Sözleşmeli aylık servis, faturalı</div>
                    <div class="service-check">GPS ile anlık araç takibi</div>
                    <div class="service-check">SRC belgeli, psikoteknik onaylı sürücü</div>
                    <div class="service-check">Aylık performans raporu</div>
                    <div class="service-check">Trafik + koltuk + mesleki sigorta</div>
                    <div class="service-check">Yedek araç 30 dk içinde</div>
                    <div class="service-check">7/24 koordinatör hattı</div>
                    <div class="service-check">Yılda 2 memnuniyet anketi</div>
                </div>

                <div class="service-cta-row">
                    <a class="btn btn-indigo btn-lg" href="<?= url('/teklif-al') ?>">Personel servisi teklifi al →</a>
                    <span class="service-meta-inline">
                        <span class="dot"></span>
                        <span>Minimum sözleşme: 3 ay · Min. 15 personel</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ SERVICE 2 — ÖĞRENCİ (reverse) ============ -->
<section class="block reveal orange" style="background:var(--bg-2)">
    <div class="wrap">
        <div class="service-detail reverse orange">
            <div class="service-media orange">
                <div class="big-num">
                    MEB<em>Standardında hizmet</em>
                </div>
            </div>
            <div class="service-content">
                <div class="eyebrow-num" style="color:var(--orange)">02 · Okullara</div>
                <div class="eyebrow-num" style="display:none"></div>
                <h2>Öğrenci Servisi</h2>
                <p class="lead">Rehber refakatinde, MEB standardında öğrenci servisi. Anasınıfından liseye tüm yaş grupları. Veli takip uygulaması ve kamera kaydı standart hizmet parçasıdır.</p>

                <div class="service-checklist">
                    <div class="service-check">MEB Onaylı servis firması</div>
                    <div class="service-check">Her araçta profesyonel rehber</div>
                    <div class="service-check">İç + dış kamera 30 gün kayıt</div>
                    <div class="service-check">Veli takip mobil uygulaması</div>
                    <div class="service-check">Emniyet kemeri kontrolü</div>
                    <div class="service-check">İnip-binmede rehber refakati</div>
                    <div class="service-check">Öğrenci sayaç doğrulaması</div>
                    <div class="service-check">Acil durum protokolü</div>
                </div>

                <div class="service-cta-row">
                    <a class="btn btn-indigo btn-lg" href="<?= url('/teklif-al') ?>" style="background:linear-gradient(135deg,var(--orange),#fb923c);box-shadow:0 8px 20px -6px rgba(249,115,22,.55)">Öğrenci servisi teklifi al →</a>
                    <span class="service-meta-inline">
                        <span class="dot" style="background:var(--orange)"></span>
                        <span>Eğitim-öğretim yılı boyu · Min. 10 öğrenci</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ SERVICE 3 — TUR & TRANSFER ============ -->
<section class="block reveal">
    <div class="wrap">
        <div class="service-detail dark">
            <div class="service-media dark">
                <div class="big-num">
                    7/24<em>Kesintisiz koordinasyon</em>
                </div>
            </div>
            <div class="service-content">
                <div class="eyebrow-num" style="color:var(--ink)">03 · Özel Talep</div>
                <h2>Tur & Transfer</h2>
                <p class="lead">Grup gezileri, havalimanı transferi, düğün ve organizasyon taşıma. VIP van'dan otobüse tam yelpaze. Tek kişilik transferden 100 kişilik gruplara kadar 7/24 hizmet.</p>

                <div class="service-checklist">
                    <div class="service-check">VIP van, minibüs, midibüs, otobüs</div>
                    <div class="service-check">Havalimanı karşılama & uğurlama</div>
                    <div class="service-check">Düğün konvoyu organizasyonu</div>
                    <div class="service-check">Şirket etkinlik ulaşımı</div>
                    <div class="service-check">Şehir dışı grup gezileri</div>
                    <div class="service-check">Tek yön / gidiş-dönüş</div>
                    <div class="service-check">7/24 rezervasyon</div>
                    <div class="service-check">Anlık fiyat teklifi</div>
                </div>

                <div class="service-cta-row">
                    <a class="btn btn-primary btn-lg" href="<?= url('/teklif-al') ?>">Transfer/tur teklifi al →</a>
                    <span class="service-meta-inline">
                        <span class="dot" style="background:var(--ink)"></span>
                        <span>Sözleşme gerekmez · Rezervasyonla çalışır</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ COMPARISON TABLE ============ -->
<section class="block reveal" style="background:var(--bg-2)">
    <div class="wrap">
        <div class="section-head" style="margin-left:auto;margin-right:auto;text-align:center">
            <div class="eyebrow">Karşılaştırma</div>
            <h2 class="title">Hangi hizmet size uygun?</h2>
            <p class="section-lede" style="margin-left:auto;margin-right:auto">Üç hizmet farklı ihtiyaca cevap veriyor. Aşağıdaki tabloda temel farkları özetledik.</p>
        </div>

        <div class="compare-wrap">
            <table class="compare-table">
                <thead>
                    <tr>
                        <th>Özellik</th>
                        <th class="col-per"><span class="th-icon">◈</span>Personel</th>
                        <th class="col-ogr"><span class="th-icon">◉</span>Öğrenci</th>
                        <th class="col-tur"><span class="th-icon">✦</span>Tur & Transfer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sözleşme Süresi</td>
                        <td>Min. 3 ay</td>
                        <td>Eğitim yılı boyu (10 ay)</td>
                        <td>Rezervasyon (tek seferlik)</td>
                    </tr>
                    <tr>
                        <td>Minimum Kişi</td>
                        <td>15 personel</td>
                        <td>10 öğrenci</td>
                        <td>1 kişi</td>
                    </tr>
                    <tr>
                        <td>Filo Tipi</td>
                        <td>Sprinter · Midibüs · Otobüs</td>
                        <td>Sprinter (14–19 kişilik)</td>
                        <td>VIP Van · Midibüs · Otobüs</td>
                    </tr>
                    <tr>
                        <td>Rehber Refakati</td>
                        <td><span class="compare-cross">—</span></td>
                        <td><span class="compare-check">✓ Her araçta</span><span class="compare-star">MEB</span></td>
                        <td>Talebe göre</td>
                    </tr>
                    <tr>
                        <td>Kamera Kaydı</td>
                        <td><span class="compare-check">✓ İç + Dış</span></td>
                        <td><span class="compare-check">✓ İç + Dış</span></td>
                        <td>Standart araçlarda</td>
                    </tr>
                    <tr>
                        <td>Veli / Kurum Uygulaması</td>
                        <td>Aylık rapor</td>
                        <td><span class="compare-check">✓ Canlı takip</span></td>
                        <td>Rezervasyon paneli</td>
                    </tr>
                    <tr>
                        <td>Fatura</td>
                        <td>Aylık kurumsal</td>
                        <td>Aylık kurumsal</td>
                        <td>Anlık fatura</td>
                    </tr>
                    <tr>
                        <td>7/24 Hat</td>
                        <td>Koordinatör hattı</td>
                        <td>Rehber + koordinatör</td>
                        <td><span class="compare-check">✓ Rezervasyon 7/24</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- ============ NASIL ÇALIŞIYORUZ ============ -->
<section class="block reveal">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Nasıl çalışıyoruz</div>
            <h2 class="title">Talep aldığımız andan itibaren dört adım.</h2>
            <p class="section-lede">İlk aramanızdan servisin ilk günü sabaha kadar geçen süreç 2 hafta içinde tamamlanır.</p>
        </div>

        <div class="process-grid">
            <div class="process-step">
                <div class="process-num">01</div>
                <div class="process-title">Talep alırız</div>
                <div class="process-desc">Kurumunuzu, personel/öğrenci sayınızı ve güzergâhınızı öğreniriz. Bir saat içinde geri dönüyoruz.</div>
                <span class="process-time">~ 1 saat</span>
            </div>
            <div class="process-step">
                <div class="process-num">02</div>
                <div class="process-title">Fizibilite çıkarırız</div>
                <div class="process-desc">Güzergâh planı, araç seçimi, sürücü ataması ve fiyat teklifini kurumsal formatta hazırlarız.</div>
                <span class="process-time">~ 24 saat</span>
            </div>
            <div class="process-step">
                <div class="process-num">03</div>
                <div class="process-title">Sözleşme imzalanır</div>
                <div class="process-desc">Detaylı sözleşme, sigorta belgeleri ve SLA parametreleri paylaşılır. Karşılıklı imzayla resmileşir.</div>
                <span class="process-time">~ 3-5 gün</span>
            </div>
            <div class="process-step">
                <div class="process-num">04</div>
                <div class="process-title">Servis başlar</div>
                <div class="process-desc">İlk hafta ekstra koordinasyon. GPS takip, aylık raporlama ve 7/24 hat devrede.</div>
                <span class="process-time">→ Sürekli</span>
            </div>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<?php
$phone = $c['contact_phone'] ?? '+90 414 000 00 00';
$phoneClean = preg_replace('/\D/', '', $phone);
?>
<section class="cta-outer reveal">
    <div class="wrap">
        <div class="cta-glass">
            <div>
                <h2>Hangisinden başlamak istersiniz?</h2>
                <p>Formu doldurun, en uygun hizmeti size özel yapılandıralım. Ya da telefondan direkt konuşalım — kahvemiz her zaman hazır.</p>
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
