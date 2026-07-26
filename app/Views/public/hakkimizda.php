<?php
/**
 * Hakkımızda sayfası.
 * $company, $foundedYear, $yearsInBiz, $stats
 */
$c            = $company    ?? [];
$founderName  = !empty($c['founder_name'])  ? $c['founder_name']  : 'Ahmet Şahin';
$founderRole  = !empty($c['founder_role'])  ? $c['founder_role']  : 'Kurucu · Genel Müdür';
$founderQuote = !empty($c['founder_quote']) ? $c['founder_quote'] : 'Bu iş güven işi. Bir sabah geciken servis, ertesi ay kaybedilen bir kurumdur. ' . (int) $yearsInBiz . ' yıldır tek işimiz insanları zamanında yerine ulaştırmak — ve bu yalın gerçeği asla unutmadık.';
// Kurucu inisiyalleri isminden otomatik
$__nameParts = preg_split('/\s+/', trim($founderName));
$founderInit = mb_strtoupper(mb_substr($__nameParts[0] ?? '', 0, 1, 'UTF-8') . mb_substr($__nameParts[1] ?? '', 0, 1, 'UTF-8'), 'UTF-8');
if (empty($founderInit)) $founderInit = 'AŞ';

$certs = !empty($c['certificates']) ? $c['certificates'] : "D2 Yetki Belgesi\nISO 9001\nMEB Onaylı";
$certList = array_filter(array_map('trim', preg_split('/\r?\n/', $certs)));
?>

<!-- ============ PAGE HERO ============ -->
<section class="page-hero">
    <div class="wrap">
        <div class="eyebrow-light">
            <span class="year-pill"><?= (int) $foundedYear ?> → <?= (int) date('Y') ?></span>
            <span>Şanlıurfa · Karaköprü</span>
        </div>
        <h1><?= (int) $yearsInBiz ?> yıldır tek işimiz:<br>insanları <span class="accent">zamanında yerine</span> ulaştırmak.</h1>
        <p class="sub"><?= (int) $foundedYear ?>'te bir minibüsle başladık, bugün <?= (int) $stats['vehicles'] ?> araçlık filoyla <?= (int) $stats['institutions'] ?> kuruma hizmet veriyoruz. Değişen tek şey ölçek — yaklaşımımız gün bir bile eskimedi.</p>
    </div>
</section>

<!-- ============ FOUNDER SPOTLIGHT ============ -->
<section class="founder-spotlight reveal">
    <div class="wrap">
        <div class="founder-card">
            <div class="founder-photo"><?= e($founderInit) ?></div>
            <div class="founder-content">
                <div class="founder-quote"><?= e($founderQuote) ?></div>
                <div class="founder-meta">
                    <span class="founder-divider"></span>
                    <div>
                        <div class="founder-name"><?= e($founderName) ?></div>
                        <div class="founder-role"><?= e($founderRole) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ TIMELINE — Yolculuk ============ -->
<section class="timeline-section reveal">
    <div class="wrap">
        <div class="section-head" style="margin-left:auto;margin-right:auto;text-align:center">
            <div class="eyebrow">Bizim yolculuğumuz</div>
            <h2 class="title">23 yıl, üç minibüsten <?= (int) $stats['vehicles'] ?> araca.</h2>
            <p class="section-lede" style="margin-left:auto;margin-right:auto">Her yıl bir kurum daha, her yıl bir araç daha. Aşağıda kilometre taşlarımız.</p>
        </div>

        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-year"><?= (int) $foundedYear ?></div>
                <div class="timeline-title">Şirket kuruldu</div>
                <div class="timeline-desc"><?= e($founderName) ?>, tek bir minibüs ile işe başladı.</div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2008</div>
                <div class="timeline-title">İlk fabrika kontratı</div>
                <div class="timeline-desc">İpekyol OSB'deki ilk kurumsal kontrat — 60 personelli sabah-akşam servis.</div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2013</div>
                <div class="timeline-title">Filo 20 araca çıktı</div>
                <div class="timeline-desc">10 yıllık büyümenin dönüm noktası. GPS sistemi tüm araçlara kuruldu.</div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2018</div>
                <div class="timeline-title">MEB onaylı öğrenci servisi</div>
                <div class="timeline-desc">Öğrenci servisi hizmetini resmen ekledik. Rehber kadrosu, veli takip sistemi devrede.</div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2023</div>
                <div class="timeline-title">20 kurum, 40 araç</div>
                <div class="timeline-desc">Şanlıurfa'nın en köklü servis firmalarından biri konumuna geldik.</div>
            </div>
            <div class="timeline-item current">
                <div class="timeline-year"><?= (int) date('Y') ?></div>
                <div class="timeline-title"><?= (int) $stats['vehicles'] ?> araç, <?= (int) $stats['institutions'] ?> kurum</div>
                <div class="timeline-desc">Bugün Karaköprü, Merkez, Eyyübiye ve Ceylanpınar hatlarında sabit servisimiz var.</div>
            </div>
        </div>
    </div>
</section>

<!-- ============ DEĞERLER ============ -->
<section class="block reveal">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Değerlerimiz</div>
            <h2 class="title">Dört ilke, her sabah taze.</h2>
            <p class="section-lede">İşe başladığımız gün ne kadar geçerliydiyse bugün de o kadar geçerli. Kod, sözleşme, denetim — hepsi bunun üstüne kurulu.</p>
        </div>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">◈</div>
                <h4>Zamanlama</h4>
                <p>Sabah 06:30 sabah 06:30'dur. Aylık ortalama gecikmemiz 2 dakikanın altında.</p>
            </div>
            <div class="value-card">
                <div class="value-icon o">◉</div>
                <h4>Şeffaflık</h4>
                <p>Sözleşme, sigorta, fiyatlandırma — her kalem müşterinin panosunda. Sürpriz yok.</p>
            </div>
            <div class="value-card">
                <div class="value-icon g">✓</div>
                <h4>İnsan Odaklılık</h4>
                <p>Sürücümüz de, müşterimiz de, yolcumuz da bize göre birer isim — birer numara değil.</p>
            </div>
            <div class="value-card">
                <div class="value-icon d">✦</div>
                <h4>Güven</h4>
                <p>Servis geciktiğinde ilk arayan bizizdir. Söz veriyoruz, sözü tutmayı iş yapmaktan üstün tutuyoruz.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ EKİP ============ -->
<section class="block reveal" style="background:var(--bg-2)">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Ekibimiz</div>
            <h2 class="title">Perde arkasındaki insanlar.</h2>
            <p class="section-lede">Filoyu koordine eden yönetim ekibi, sabahları erken kalkan sürücüler ve haftada 6 gün rota planlayan operasyon kadrosu.</p>
        </div>

        <div class="team-grid">
            <div class="team-card">
                <div class="team-avatar">AŞ</div>
                <div class="team-name">Ahmet Şahin</div>
                <div class="team-role">Kurucu · Genel Müdür</div>
                <span class="team-badge">23 yıl</span>
            </div>
            <div class="team-card">
                <div class="team-avatar orange">MŞ</div>
                <div class="team-name">Mehmet Şahin</div>
                <div class="team-role">Filo Koordinatörü</div>
                <span class="team-badge">12 yıl</span>
            </div>
            <div class="team-card">
                <div class="team-avatar dark">EK</div>
                <div class="team-name">Emine Kaya</div>
                <div class="team-role">Operasyon Müdürü</div>
                <span class="team-badge">8 yıl</span>
            </div>
            <div class="team-card">
                <div class="team-avatar">HŞ</div>
                <div class="team-name">Hasan Şahin</div>
                <div class="team-role">Bakım Sorumlusu</div>
                <span class="team-badge">15 yıl</span>
            </div>
            <div class="team-card">
                <div class="team-avatar orange">32+</div>
                <div class="team-name">Sürücü Kadrosu</div>
                <div class="team-role">SRC belgeli, psikoteknik onaylı</div>
                <span class="team-badge">Ortalama 8 yıl</span>
            </div>
            <div class="team-card">
                <div class="team-avatar dark">6</div>
                <div class="team-name">Rehber Kadrosu</div>
                <div class="team-role">Öğrenci servisleri için</div>
                <span class="team-badge">MEB onaylı</span>
            </div>
        </div>
    </div>
</section>

<!-- ============ SERTİFİKALAR ============ -->
<section class="block reveal">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Belgeler & Sertifikalar</div>
            <h2 class="title">Kayıt altında, denetlenir.</h2>
            <p class="section-lede">Aşağıdaki belgelerin hepsi resmi kurumlarca verilmiştir. Sözleşme öncesi tüm belgeleri sizinle paylaşırız.</p>
        </div>

        <div class="certs-grid">
            <?php
            $medalClasses = ['', 'o', 'g'];
            foreach ($certList as $i => $cert):
                $cls = $medalClasses[$i % 3];
            ?>
            <div class="cert-card">
                <div class="cert-medal <?= $cls ?>">🎖</div>
                <div class="cert-info">
                    <h5><?= e($cert) ?></h5>
                    <p>Geçerli · Belge sözleşme öncesi paylaşılır</p>
                </div>
            </div>
            <?php endforeach; ?>
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
                <h2>Bizi daha yakından tanımak ister misiniz?</h2>
                <p>Ofisimize buyurun, filomuzu ve ekibimizi bizzat görün. Kahvemiz her zaman hazır.</p>
            </div>
            <div class="cta-glass-actions">
                <a class="btn btn-indigo btn-lg" href="<?= url('/iletisim') ?>">İletişime geç →</a>
                <a class="cta-phone" href="tel:<?= e($phoneClean) ?>">
                    <span>Ya da direkt arayın:</span>
                    <span class="num"><?= e($phone) ?></span>
                </a>
            </div>
        </div>
    </div>
</section>
