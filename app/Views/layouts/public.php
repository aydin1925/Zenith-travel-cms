<?php
/**
 * Public site layout.
 * Beklenen degiskenler:
 *   $pageTitle   - <title>
 *   $activePage  - hangi nav item aktif (home|hakkimizda|hizmetlerimiz|filo|rotalar|referanslarimiz|sss|iletisim|teklif-al)
 *   $company     - settings tablosundan sirket bilgileri array'i
 *   $content     - render edilen sayfa gövdesi
 */
$activePage = $activePage ?? 'home';
$pageTitle  = $pageTitle  ?? 'Sahin Tasimacilik';
$c          = $company    ?? [];

$name  = $c['company_name']    ?? 'Sahin Tasimacilik';
$cat   = $c['company_category']?? 'Personel & Ogrenci Tasimaciligi';
$phone = $c['contact_phone']   ?? '+90 414 000 00 00';
$email = $c['contact_email']   ?? 'info@sahin.com.tr';
$addr  = $c['address']         ?? 'Karaköprü / Şanlıurfa';
$about = $c['about_text']      ?? 'Şanlıurfa\'nın en köklü personel ve öğrenci taşımacılığı firması. 23 yıldır aynı saat, aynı sorumluluk.';
$certs = !empty($c['certificates']) ? $c['certificates'] : "D2 Yetki Belgesi\nISO 9001\nMEB Onaylı";
$certList = array_filter(array_map('trim', preg_split('/\r?\n/', $certs)));

// WhatsApp icin sadece rakam
$waNum = preg_replace('/\D/', '', $phone);
if (!empty($waNum) && str_starts_with($waNum, '0')) $waNum = '90' . substr($waNum, 1);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= asset('css/public.css') ?>">
</head>
<body>

<!-- ============ NAV ============ -->
<nav class="nav">
    <div class="nav-inner">
        <a class="logo" href="<?= url('/') ?>">
            <span class="logo-mark"></span>
            <?= e($name) ?>
        </a>
        <ul class="nav-links">
            <li><a href="<?= url('/hakkimizda') ?>"      class="<?= $activePage==='hakkimizda' ? 'active' : '' ?>">Hakkımızda</a></li>
            <li><a href="<?= url('/hizmetlerimiz') ?>"   class="<?= $activePage==='hizmetlerimiz' ? 'active' : '' ?>">Hizmetler</a></li>
            <li><a href="<?= url('/filo') ?>"            class="<?= $activePage==='filo' ? 'active' : '' ?>">Filo</a></li>
            <li><a href="<?= url('/rotalar') ?>"         class="<?= $activePage==='rotalar' ? 'active' : '' ?>">Rotalar</a></li>
            <li><a href="<?= url('/referanslarimiz') ?>" class="<?= $activePage==='referanslarimiz' ? 'active' : '' ?>">Referanslar</a></li>
            <li><a href="<?= url('/sss') ?>"             class="<?= $activePage==='sss' ? 'active' : '' ?>">SSS</a></li>
            <li><a href="<?= url('/iletisim') ?>"        class="<?= $activePage==='iletisim' ? 'active' : '' ?>">İletişim</a></li>
        </ul>
        <div class="nav-actions">
            <a class="btn btn-ghost" href="tel:<?= e($waNum ? '+' . $waNum : $phone) ?>"><?= e($phone) ?></a>
            <a class="btn btn-primary" href="<?= url('/teklif-al') ?>">Teklif Al →</a>
        </div>
    </div>
</nav>

<!-- ============ MAIN CONTENT ============ -->
<?= $content ?>

<!-- ============ WHATSAPP FLOAT ============ -->
<?php if ($waNum): ?>
<div class="wa-wrap">
    <a href="https://wa.me/<?= e($waNum) ?>" class="wa-float" title="WhatsApp ile mesaj" target="_blank" rel="noopener">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>
</div>
<?php endif; ?>

<!-- ============ FOOTER ============ -->
<footer>
    <div class="wrap">
        <div class="foot-grid">
            <div class="foot-brand">
                <a class="logo" href="<?= url('/') ?>">
                    <span class="logo-mark"></span>
                    <?= e($name) ?>
                </a>
                <p><?= e($about) ?></p>
                <?php if (!empty($certList)): ?>
                <div class="foot-certs">
                    <?php foreach ($certList as $cert): ?>
                        <span class="foot-cert"><?= e($cert) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="foot-col">
                <h4>Hizmetler</h4>
                <ul>
                    <li><a href="<?= url('/hizmetlerimiz') ?>">Personel Servisi</a></li>
                    <li><a href="<?= url('/hizmetlerimiz') ?>">Öğrenci Servisi</a></li>
                    <li><a href="<?= url('/hizmetlerimiz') ?>">Tur & Transfer</a></li>
                    <li><a href="<?= url('/filo') ?>">Filomuz</a></li>
                    <li><a href="<?= url('/rotalar') ?>">Rotalar</a></li>
                </ul>
            </div>
            <div class="foot-col">
                <h4>Kurumsal</h4>
                <ul>
                    <li><a href="<?= url('/hakkimizda') ?>">Hakkımızda</a></li>
                    <li><a href="<?= url('/referanslarimiz') ?>">Referanslar</a></li>
                    <li><a href="<?= url('/sss') ?>">SSS</a></li>
                    <li><a href="<?= url('/teklif-al') ?>">Teklif Al</a></li>
                </ul>
            </div>
            <div class="foot-col">
                <h4>İletişim</h4>
                <ul>
                    <li><?= e($phone) ?></li>
                    <li><?= e($email) ?></li>
                    <li><?= e($addr) ?></li>
                </ul>
            </div>
        </div>
        <div class="foot-bottom">
            <span>© <?= date('Y') ?> <?= e($name) ?>. Tüm hakları saklıdır.</span>
            <span>Zenith CMS ile yönetiliyor</span>
        </div>
    </div>
</footer>

<script>
// Sticky storyboard: scroll'da hangi hizmet ortadaysa soldaki gorseli degistir
(function () {
    const items = document.querySelectorAll('.storyboard .story-item');
    const media = document.querySelector('.storyboard .story-media');
    const title = document.querySelector('.storyboard .story-title');
    if (!items.length || !media || !title) return;

    const titles = {
        '1': 'Personel<br>Servisi<em>Fabrika, ofis ve OSB için.</em>',
        '2': 'Öğrenci<br>Servisi<em>Rehber refakatinde, MEB standardında.</em>',
        '3': 'Tur &<br>Transfer<em>7/24 grup, transfer, VIP.</em>'
    };
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                items.forEach(x => x.classList.remove('on'));
                e.target.classList.add('on');
                const idx = e.target.getAttribute('data-idx');
                media.setAttribute('data-active', idx);
                if (titles[idx]) title.innerHTML = titles[idx];
            }
        });
    }, { rootMargin: '-40% 0px -40% 0px', threshold: 0 });
    items.forEach(i => io.observe(i));
})();

// Scroll-triggered reveal
const io2 = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('on'); io2.unobserve(e.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => io2.observe(el));
</script>

</body>
</html>
