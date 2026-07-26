<?php
/**
 * Referanslar sayfasi.
 * $institutions, $typeCounts, $total, $company
 */
$c = $company ?? [];

// Kurum tipine gore chip class + label
function inst_type_chip(?string $type): array {
    $map = [
        'Okul'   => ['okul', 'Okul'],
        'Sirket' => ['sirket', 'Şirket'],
        'Acente' => ['acente', 'Acente'],
        'Diger'  => ['diger', 'Diğer'],
    ];
    return $map[$type ?? 'Diger'] ?? ['diger', $type ?? 'Diğer'];
}

// Kurum tipine gore mark rengi
function inst_mark_class(?string $type): string {
    return match($type ?? 'Diger') {
        'Okul'   => 'o',
        'Sirket' => '',
        'Acente' => 'g',
        default  => 'd',
    };
}

// Ilk harflerini uret (baslikta ki fun kucuk mark icin)
function inst_initials(string $name): string {
    $clean = preg_replace('/[^\p{L}\s]/u', '', $name);
    $words = preg_split('/\s+/', trim($clean));
    if (count($words) === 1) return mb_strtoupper(mb_substr($words[0], 0, 2, 'UTF-8'), 'UTF-8');
    return mb_strtoupper(mb_substr($words[0], 0, 1, 'UTF-8') . mb_substr($words[1] ?? '', 0, 1, 'UTF-8'), 'UTF-8');
}

// baseData'dan gelir; yoksa fallback
$yearsInBiz = $yearsInBiz ?? ((int) date('Y') - ($foundedYear ?? 2003));
?>

<!-- ============ PAGE HERO ============ -->
<section class="page-hero">
    <div class="wrap">
        <div class="eyebrow-light">
            <span class="year-pill"><?= (int) $total ?> kurum</span>
            <span>Kesintisiz <?= (int) $yearsInBiz ?> yıl</span>
        </div>
        <h1><?= (int) $total ?> kurumla,<br><span class="accent">kesintisiz sözleşme.</span></h1>
        <p class="sub">Şanlıurfa'nın en köklü fabrika, okul, üniversite ve devlet kurumlarıyla çalışıyoruz. Aşağıdaki liste sürekli güncellenir — her yeni kurum, güvenin bir kanıtı.</p>
    </div>
</section>

<!-- ============ FEATURED CASE STUDIES ============ -->
<section class="block reveal">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Öne çıkan işbirlikleri</div>
            <h2 class="title">En uzun süreli üç ortaklığımız.</h2>
            <p class="section-lede">Yıllar geçtikçe hikaye derinleşiyor. İşte en uzun süreli üç kurumsal partnerimizin sözleri ve rakamları.</p>
        </div>

        <div class="case-grid">
            <article class="case-card indigo">
                <div>
                    <div class="case-badge">◈ 12 yıllık ortaklık</div>
                    <div class="case-quote">15 yıldır bize sabahları güvenle geliyorlar. Bir kez olsun geciken personel görmedik.</div>
                    <div class="case-author">
                        <div class="case-avatar">MY</div>
                        <div>
                            <div class="case-name">Mehmet Yılmaz</div>
                            <div class="case-role">İK Müdürü · SANKO Tekstil</div>
                        </div>
                    </div>
                </div>
                <div class="case-stats">
                    <div class="case-stat"><div class="case-stat-num">12</div><div class="case-stat-label">yıldır</div></div>
                    <div class="case-stat"><div class="case-stat-num">180</div><div class="case-stat-label">personel/gün</div></div>
                    <div class="case-stat"><div class="case-stat-num">6</div><div class="case-stat-label">araç</div></div>
                </div>
            </article>

            <article class="case-card dark">
                <div>
                    <div class="case-badge">◉ 8 yıllık ortaklık</div>
                    <div class="case-quote">Velileri arayan tek servis firmasıyız burada. Anne baba rahat, öğrenci güvende.</div>
                    <div class="case-author">
                        <div class="case-avatar">AY</div>
                        <div>
                            <div class="case-name">Ayşe Yıldız</div>
                            <div class="case-role">Müdür · Cumhuriyet A.L.</div>
                        </div>
                    </div>
                </div>
                <div class="case-stats">
                    <div class="case-stat"><div class="case-stat-num">8</div><div class="case-stat-label">yıldır</div></div>
                    <div class="case-stat"><div class="case-stat-num">220</div><div class="case-stat-label">öğrenci/gün</div></div>
                    <div class="case-stat"><div class="case-stat-num">7</div><div class="case-stat-label">araç</div></div>
                </div>
            </article>

            <article class="case-card orange">
                <div>
                    <div class="case-badge">✦ 5 yıllık ortaklık</div>
                    <div class="case-quote">Kampüs–şehir hattımızın standardı. Akademisyenler saatlerini bize göre ayarlıyor.</div>
                    <div class="case-author">
                        <div class="case-avatar">AK</div>
                        <div>
                            <div class="case-name">Prof. Dr. Ali Kara</div>
                            <div class="case-role">Rektör Yardımcısı · Harran Üniversitesi</div>
                        </div>
                    </div>
                </div>
                <div class="case-stats">
                    <div class="case-stat"><div class="case-stat-num">5</div><div class="case-stat-label">yıldır</div></div>
                    <div class="case-stat"><div class="case-stat-num">340</div><div class="case-stat-label">akademisyen/gün</div></div>
                    <div class="case-stat"><div class="case-stat-num">10</div><div class="case-stat-label">araç</div></div>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- ============ FULL LIST + FILTER ============ -->
<section class="block reveal" style="background:var(--bg-2)">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Tam Liste</div>
            <h2 class="title">Bize güvenen tüm kurumlar.</h2>
            <p class="section-lede">Aşağıdaki liste admin panelinden güncel tutulur. Kategoriye göre filtreleyebilirsiniz.</p>
        </div>

        <!-- Filter pills — fleet-pill class'ini yeniden kullaniyorum -->
        <div class="fleet-filter" id="instFilter">
            <button class="fleet-pill active" data-cat="all">
                Tümü <span class="count"><?= (int) $total ?></span>
            </button>
            <button class="fleet-pill" data-cat="Okul">
                Okullar <span class="count"><?= (int) $typeCounts['Okul'] ?></span>
            </button>
            <button class="fleet-pill" data-cat="Sirket">
                Şirketler <span class="count"><?= (int) $typeCounts['Sirket'] ?></span>
            </button>
            <button class="fleet-pill" data-cat="Acente">
                Acenteler <span class="count"><?= (int) $typeCounts['Acente'] ?></span>
            </button>
            <button class="fleet-pill" data-cat="Diger">
                Diğer <span class="count"><?= (int) $typeCounts['Diger'] ?></span>
            </button>
        </div>

        <div class="inst-grid" id="instGrid">
            <?php if (empty($institutions)): ?>
                <div class="inst-empty">
                    <i>🏢</i>
                    <h4>Henüz kayıtlı bir kurum yok</h4>
                    <p>Admin panelinden kurum eklendikçe burada görünecek.</p>
                </div>
            <?php else: ?>
                <?php foreach ($institutions as $inst):
                    [$chipCls, $chipLabel] = inst_type_chip($inst['type'] ?? null);
                    $markCls = inst_mark_class($inst['type'] ?? null);
                    $initials = inst_initials($inst['institution_name']);
                ?>
                <article class="inst-card" data-cat="<?= e($inst['type'] ?? 'Diger') ?>">
                    <div class="inst-mark <?= e($markCls) ?>">
                        <?php if (!empty($inst['logo_url'])): ?>
                            <img src="<?= e(\App\Core\FileUploader::url($inst['logo_url'])) ?>" alt="">
                        <?php else: ?>
                            <?= e($initials) ?>
                        <?php endif; ?>
                    </div>
                    <div class="inst-info">
                        <div class="inst-name" title="<?= e($inst['institution_name']) ?>">
                            <?= e($inst['institution_name']) ?>
                        </div>
                        <div class="inst-type-line">
                            <span class="inst-type-chip <?= e($chipCls) ?>"><?= e($chipLabel) ?></span>
                            <?php if (!empty($inst['contact_person'])): ?>
                                <span>· <?= e($inst['contact_person']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ============ TRUST RIBBON ============ -->
<section class="block reveal">
    <div class="wrap">
        <div class="trust-ribbon">
            <div class="trust-item">
                <div class="trust-num"><?= (int) $total ?><span class="unit">+</span></div>
                <div class="trust-label">Aktif Sözleşme</div>
            </div>
            <div class="trust-item">
                <div class="trust-num"><?= (int) $yearsInBiz ?><span class="unit">yıl</span></div>
                <div class="trust-label">Sektör Deneyimi</div>
            </div>
            <div class="trust-item">
                <div class="trust-num">%99.8</div>
                <div class="trust-label">Zamanında Servis</div>
            </div>
            <div class="trust-item">
                <div class="trust-num">%94</div>
                <div class="trust-label">Sözleşme Yenilenme</div>
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
                <h2>Kurumunuz da bu listede olsun.</h2>
                <p>Personel sayınızı ve güzergâhınızı iletin — bir saat içinde teklifle dönelim. Sözleşme öncesi referans kurumları gerçekten arayabilirsiniz.</p>
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

<script>
// Kurum tipi filter
(function () {
    const pills = document.querySelectorAll('#instFilter .fleet-pill');
    const cards = document.querySelectorAll('#instGrid .inst-card');
    pills.forEach(p => p.addEventListener('click', () => {
        pills.forEach(x => x.classList.remove('active'));
        p.classList.add('active');
        const cat = p.getAttribute('data-cat');
        cards.forEach(c => {
            const match = cat === 'all' || c.getAttribute('data-cat') === cat;
            c.classList.toggle('hidden', !match);
        });
    }));
})();
</script>
