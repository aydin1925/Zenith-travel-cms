<?php
/**
 * Filo (tum araclar) sayfasi.
 * $vehicles, $categorized, $total, $company
 */
$c = $company ?? [];

// Helper: DB'deki type kolonundan direkt kategori
function veh_category(array $v): array {
    $type = $v['type'] ?? 'sprinter';
    return match($type) {
        'vip'      => ['vip',      'VIP',     'gold'],
        'midibus'  => ['midibus',  'Midibüs', 'orange'],
        'otobus'   => ['otobus',   'Otobüs',  'green'],
        default    => ['sprinter', 'Sprinter', ''],
    };
}

// Helper: features metnini virgul/yeni satirla parcala
function veh_features_list(?string $features): array {
    if (!$features) return [];
    $parts = preg_split('/[,\n]/', $features);
    return array_slice(array_filter(array_map('trim', $parts)), 0, 3);
}
?>

<!-- ============ PAGE HERO ============ -->
<section class="page-hero">
    <div class="wrap">
        <div class="eyebrow-light">
            <span class="year-pill"><?= (int) $total ?> araç</span>
            <span>Sanliurfa · <?= (int) $categorized['sprinter'] + (int) $categorized['midibus'] + (int) $categorized['otobus'] + (int) $categorized['vip'] ?> aktif</span>
        </div>
        <h1><?= (int) $total ?> araçlık filo.<br><span class="accent">Hepsi kayıtlı, hepsi bakımlı.</span></h1>
        <p class="sub">GPS takipli, kamera kayıtlı, SRC belgeli sürücülerle çalışan tam donanımlı filo. Aşağıdan kategoriye göre filtreleyebilir, her aracın plakasını ve özelliklerini inceleyebilirsiniz.</p>
    </div>
</section>

<!-- ============ VEHICLE LIST ============ -->
<section class="block reveal">
    <div class="wrap">

        <!-- Filter pills -->
        <div class="fleet-filter" id="fleetFilter">
            <button class="fleet-pill active" data-cat="all">
                Tümü <span class="count"><?= (int) $total ?></span>
            </button>
            <button class="fleet-pill" data-cat="sprinter">
                Sprinter <span class="count"><?= (int) $categorized['sprinter'] ?></span>
            </button>
            <button class="fleet-pill" data-cat="midibus">
                Midibüs <span class="count"><?= (int) $categorized['midibus'] ?></span>
            </button>
            <button class="fleet-pill" data-cat="otobus">
                Otobüs <span class="count"><?= (int) $categorized['otobus'] ?></span>
            </button>
            <button class="fleet-pill" data-cat="vip">
                VIP Van <span class="count"><?= (int) $categorized['vip'] ?></span>
            </button>
        </div>

        <!-- Vehicle grid -->
        <div class="vehicle-grid" id="vehicleGrid">
            <?php if (empty($vehicles)): ?>
                <div class="vehicle-empty">
                    <i>🚐</i>
                    <h4>Filoya henüz araç eklenmemiş</h4>
                    <p>Admin panelinden araç eklendikçe burada görünecek.</p>
                </div>
            <?php else: ?>
                <?php foreach ($vehicles as $v):
                    [$catKey, $catLabel, $photoTone] = veh_category($v);
                    $feats  = veh_features_list($v['features'] ?? null);
                    $status = $v['status'] ?? 'aktif';
                    $statusLabel = ['aktif' => 'Aktif', 'bakimda' => 'Bakımda', 'pasif' => 'Pasif'][$status] ?? 'Aktif';
                ?>
                <article class="vehicle-card" data-cat="<?= e($catKey) ?>">
                    <div class="vehicle-photo <?= e($photoTone) ?>">
                        <span class="vehicle-plate"><?= e($v['plate_number']) ?></span>
                        <span class="vehicle-status <?= e($status) ?>"><?= e($statusLabel) ?></span>
                        <?php if (!empty($v['photo_url'])): ?>
                            <img src="<?= e(\App\Core\FileUploader::url($v['photo_url'])) ?>" alt=""
                                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                            🚐
                        <?php endif; ?>
                    </div>
                    <div class="vehicle-body">
                        <span class="vehicle-cat <?= e($catKey) ?>"><?= e($catLabel) ?></span>
                        <div class="vehicle-model"><?= e($v['brand_model']) ?></div>
                        <div class="vehicle-meta">
                            <?php if (!empty($v['capacity'])): ?>
                                <?= (int) $v['capacity'] ?> kişilik
                            <?php endif; ?>
                            <?php if (!empty($v['model_year'])): ?>
                                <?= !empty($v['capacity']) ? ' · ' : '' ?><?= (int) $v['model_year'] ?> model
                            <?php endif; ?>
                        </div>
                        <div class="vehicle-features">
                            <?php if (!empty($feats)): ?>
                                <?php foreach ($feats as $f): ?>
                                    <span class="vehicle-feat"><?= e($f) ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="vehicle-feat">GPS</span>
                                <span class="vehicle-feat">Klima</span>
                                <span class="vehicle-feat">Kamera</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- ============ FLEET STANDARDS (koyu ribbon) ============ -->
<section class="block reveal">
    <div class="wrap">
        <div class="standards-panel">
            <div class="standards-inner">
                <div class="standards-head">
                    <div class="eyebrow">Standartlarımız</div>
                    <h2>Her araç aynı denetimden geçer.</h2>
                    <p>Filodaki her araç aynı bakım programına, aynı güvenlik protokolüne, aynı sürücü standardına tabidir. Şoför ya da kurum farkı gözetmez.</p>
                </div>

                <div class="standards-grid">
                    <div class="standard-item">
                        <div class="standard-icon">◈</div>
                        <div class="standard-title">GPS Takip</div>
                        <div class="standard-desc">Her araç 7/24 GPS ile izleniyor. Anlık konum, hız, güzergâh kaydı tutulur.</div>
                    </div>
                    <div class="standard-item">
                        <div class="standard-icon o">◉</div>
                        <div class="standard-title">Kamera Kayıt</div>
                        <div class="standard-desc">İç ve dış kamera kaydı. Kayıtlar 30 gün saklanır, talep halinde paylaşılır.</div>
                    </div>
                    <div class="standard-item">
                        <div class="standard-icon g">✓</div>
                        <div class="standard-title">SRC Belgesi</div>
                        <div class="standard-desc">Her sürücü SRC belgeli, psikoteknik onaylı. Yılda bir tekrar sınav.</div>
                    </div>
                    <div class="standard-item">
                        <div class="standard-icon d">✦</div>
                        <div class="standard-title">Bakım Takvimi</div>
                        <div class="standard-desc">Her 15.000 km'de periyodik bakım. Muayene tarihleri panele işlenir.</div>
                    </div>
                </div>
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
                <h2>Filomuzdan hangisi size uygun?</h2>
                <p>Personel sayınızı ve güzergâhınızı iletin — filodan en uygun aracı biz seçelim, fiyat teklifiyle birlikte size dönelim.</p>
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
// Kategori filter
(function () {
    const pills = document.querySelectorAll('#fleetFilter .fleet-pill');
    const cards = document.querySelectorAll('#vehicleGrid .vehicle-card');
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
