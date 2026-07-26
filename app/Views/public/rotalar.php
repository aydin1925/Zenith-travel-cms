<?php
/**
 * Rotalar sayfası.
 * $services (JOIN'li), $typeCounts, $total, $company
 */
$c = $company ?? [];

// service_type -> tag class + label
function route_type(?string $type): array {
    $t = mb_strtolower($type ?? '', 'UTF-8');
    if (str_contains($t, 'personel')) return ['per', 'Personel'];
    if (str_contains($t, 'ogrenci') || str_contains($t, 'öğrenci')) return ['ogr', 'Öğrenci'];
    return ['ozl', $type ?: 'Özel'];
}

// Servis icin zaman slot'u — DB'de time kolonu yok, sirayla rotasyonla placeholder
$timeSlots = ['06:30', '07:15', '07:45', '08:00', '08:30', '16:30', '17:15', '17:30', '18:00'];
?>

<!-- ============ PAGE HERO ============ -->
<section class="page-hero">
    <div class="wrap">
        <div class="eyebrow-light">
            <span class="year-pill"><?= (int) $total ?> hat</span>
            <span>Personel: <?= (int) $typeCounts['personel'] ?> · Öğrenci: <?= (int) $typeCounts['ogrenci'] ?></span>
        </div>
        <h1>Sabit hatlarımız,<br><span class="accent">tam vaktinde her sabah.</span></h1>
        <p class="sub">Karaköprü, Merkez, Eyyübiye ve Ceylanpınar hatlarında düzenli servisimiz var. Aşağıdan hattınızı arayabilir ya da <?= (int) $total ?> sabit rotamıza göz atabilirsiniz. Rotanız listede yoksa özel hat açıyoruz.</p>
    </div>
</section>

<!-- ============ SEARCH + TIMETABLE ============ -->
<section class="block reveal">
    <div class="wrap">

        <!-- Arama kutusu -->
        <form class="route-search" onsubmit="event.preventDefault(); filterRoutes(document.getElementById('routeSearch').value);">
            <span class="search-ico">🔍</span>
            <input type="text" id="routeSearch" placeholder="Semt, kurum veya mahalle adı yazın (örn: Karaköprü, SANKO, İpekyol)"
                   oninput="filterRoutes(this.value)">
            <button type="submit">Ara</button>
        </form>

        <!-- Timetable panel -->
        <div class="timetable-panel">
            <div class="timetable-inner">
                <div class="timetable-head">
                    <div>
                        <h3>Haftalık sabit tarife</h3>
                        <p>Aşağıdaki saatler ortalama kalkış saatleridir. Kurumsal sözleşmede gerçek saatler netleşir.</p>
                    </div>
                    <div class="timetable-tabs" id="routeTabs">
                        <button class="timetable-tab active" data-tab="all">Tümü <span class="cnt"><?= (int) $total ?></span></button>
                        <button class="timetable-tab" data-tab="per">Personel <span class="cnt"><?= (int) $typeCounts['personel'] ?></span></button>
                        <button class="timetable-tab" data-tab="ogr">Öğrenci <span class="cnt"><?= (int) $typeCounts['ogrenci'] ?></span></button>
                        <?php if ($typeCounts['ozel'] > 0): ?>
                        <button class="timetable-tab" data-tab="ozl">Özel <span class="cnt"><?= (int) $typeCounts['ozel'] ?></span></button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="routes-list" id="routesList">
                    <?php if (empty($services)): ?>
                        <div class="routes-empty">
                            <i>🛣️</i>
                            <h4>Rota kaydı henüz yok</h4>
                            <p>Admin panelinden servis eklendikçe burada görünecek.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($services as $i => $s):
                            [$tagCls, $tagLabel] = route_type($s['service_type']);
                            $time = $timeSlots[$i % count($timeSlots)];
                            $searchText = mb_strtolower(
                                ($s['service_title'] ?? '') . ' ' .
                                ($s['institution_name'] ?? '') . ' ' .
                                ($s['vehicle_plate'] ?? '')
                            , 'UTF-8');
                        ?>
                        <div class="route-row" data-cat="<?= e($tagCls) ?>" data-search="<?= e($searchText) ?>">
                            <div class="route-time"><?= e($time) ?></div>
                            <div>
                                <div class="route-path"><?= e($s['service_title']) ?></div>
                                <?php if (!empty($s['institution_name'])): ?>
                                    <div class="route-inst"><?= e($s['institution_name']) ?></div>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($s['vehicle_plate'])): ?>
                                <div class="route-veh"><?= e($s['vehicle_plate']) ?></div>
                            <?php else: ?>
                                <div></div>
                            <?php endif; ?>
                            <div class="route-tag <?= e($tagCls) ?>"><?= e($tagLabel) ?></div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if (!empty($services)): ?>
                <div class="routes-cta">
                    <span>Rotanızı bulamadınız mı?</span>
                    <a href="#custom-route">Özel hat talep et →</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ============ COVERAGE AREA ============ -->
<section class="block reveal" style="background:var(--bg-2)">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow">Çalışma Bölgemiz</div>
            <h2 class="title">Hizmet verdiğimiz semtler.</h2>
            <p class="section-lede">Şanlıurfa merkez ve çevre ilçelerde düzenli servisimiz var. Her bölgede sabit hat + özel talep yapabilirsiniz.</p>
        </div>

        <div class="coverage-grid">
            <div class="district-card featured">
                <span class="district-badge">◈ Ana bölgemiz</span>
                <div class="district-name">Karaköprü</div>
                <div class="district-meta">En yoğun personel ve öğrenci hattımız. Sabah 06:30, akşam 17:30 sabit kalkışlarımız var.</div>
                <div class="district-lines">
                    <span class="district-line">Merkez</span>
                    <span class="district-line">Selahaddin Mh.</span>
                    <span class="district-line">Şair Nabi</span>
                    <span class="district-line">Yenice</span>
                </div>
            </div>
            <div class="district-card">
                <span class="district-badge">◉ Sabit hat</span>
                <div class="district-name">Merkez / Eyyübiye</div>
                <div class="district-meta">Merkez-Harran Üniversitesi ve merkez-fabrika hatlarımız. Vardiyalı hastane servislerimiz de burada.</div>
                <div class="district-lines">
                    <span class="district-line">Eyyübiye</span>
                    <span class="district-line">Harran Üni.</span>
                    <span class="district-line">Devlet Hastanesi</span>
                </div>
            </div>
            <div class="district-card">
                <span class="district-badge">◉ Sabit hat</span>
                <div class="district-name">İpekyol OSB</div>
                <div class="district-meta">Sanayi bölgesindeki üç fabrikaya sabah 06:30, akşam 17:30 servisimiz düzenli çalışıyor.</div>
                <div class="district-lines">
                    <span class="district-line">1. Kısım</span>
                    <span class="district-line">2. Kısım</span>
                    <span class="district-line">3. Kısım</span>
                </div>
            </div>
            <div class="district-card">
                <span class="district-badge">✦ Uzun hat</span>
                <div class="district-name">Ceylanpınar</div>
                <div class="district-meta">Merkez-Ceylanpınar hattımız 08:00'de kalkar. Devlet Hastanesi ve Belediye personel servisi.</div>
                <div class="district-lines">
                    <span class="district-line">Merkez</span>
                    <span class="district-line">Hastane</span>
                    <span class="district-line">Belediye</span>
                </div>
            </div>
            <div class="district-card">
                <span class="district-badge">◈ Özel talep</span>
                <div class="district-name">Diğer bölgeler</div>
                <div class="district-meta">Suruç, Birecik, Halfeti gibi bölgelerde 15+ yolculuk gruplar için özel hat açıyoruz.</div>
                <div class="district-lines">
                    <span class="district-line">Suruç</span>
                    <span class="district-line">Birecik</span>
                    <span class="district-line">Halfeti</span>
                    <span class="district-line">+ diğer</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ ÖZEL ROTA CTA ============ -->
<section class="block reveal" id="custom-route">
    <div class="wrap">
        <div class="custom-route">
            <div class="custom-route-icon">🛣️</div>
            <div>
                <h3>Rotanız listede yok mu?<br>Özel hat açalım.</h3>
                <p>15+ yolculuk gruplar için özel hat kuruyoruz. Rota fizibilitesini 24 saat içinde çıkarıp size dönüyoruz — noktadan noktaya güzergâh + araç önerisi + fiyat.</p>
            </div>
            <div class="custom-route-actions">
                <a class="btn btn-indigo btn-lg" href="<?= url('/teklif-al') ?>">Özel rota talep et →</a>
                <span class="custom-route-meta">
                    <span class="dot"></span>
                    <span>Ortalama yanıt: 12 dakika</span>
                </span>
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
                <h2>Rotalarımız uygun geldi mi?<br>Şimdi teklif alın.</h2>
                <p>Kurum bilginizi ve tercih ettiğiniz saati iletin, size özel hesaplayıp bir saat içinde dönelim.</p>
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
// Sekme filtresi (tümü / personel / öğrenci / özel)
(function () {
    const tabs = document.querySelectorAll('#routeTabs .timetable-tab');
    const rows = document.querySelectorAll('#routesList .route-row');
    let currentCat = 'all';
    let currentSearch = '';

    function apply() {
        rows.forEach(r => {
            const matchCat = currentCat === 'all' || r.getAttribute('data-cat') === currentCat;
            const matchSearch = !currentSearch || (r.getAttribute('data-search') || '').includes(currentSearch);
            r.classList.toggle('hidden', !(matchCat && matchSearch));
        });
    }

    tabs.forEach(t => t.addEventListener('click', () => {
        tabs.forEach(x => x.classList.remove('active'));
        t.classList.add('active');
        currentCat = t.getAttribute('data-tab');
        apply();
    }));

    // Search fonksiyonunu global tanımla (form/input onsubmit ile kullaniliyor)
    window.filterRoutes = function (q) {
        currentSearch = (q || '').toLowerCase().trim();
        apply();
    };
})();
</script>
