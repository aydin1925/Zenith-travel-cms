<?php
/**
 * SSS (FAQ) sayfası.
 * $company (nav + footer + iletisim CTA icin)
 */
$c = $company ?? [];

// FAQ verisi — sonradan settings/faqs tablosuna tasinabilir
$faqCategories = [
    'genel' => [
        'label' => 'Genel',
        'icon'  => '◈',
        'iconCls' => '',
        'items' => [
            ['Sözleşme minimum ne kadar?', 'Personel servisi için minimum 3 aylık sözleşme yapıyoruz. Öğrenci servisi eğitim-öğretim yılı boyu (Eylül–Haziran) taahhütlü çalışır. Tur ve transfer için sözleşme gerekmez, tek seferlik rezervasyon yeterlidir.'],
            ['Sigortalar dahil mi?', 'Trafik sigortası, koltuk sigortası ve mesleki sorumluluk sigortası tamamı fiyata dahildir. Sözleşme öncesi tüm belgeleri sizinle paylaşırız — orijinallerini görmek isterseniz ofise davet ediyoruz.'],
            ['Fatura kesiyor musunuz?', 'Evet, tüm hizmetlerimizde kurumsal fatura kesiyoruz. Personel ve öğrenci servisinde aylık toplu fatura, tur/transferde ise anlık fatura verilir.'],
            ['Hangi bölgelerde çalışıyorsunuz?', 'Şanlıurfa merkez, Karaköprü, Eyyübiye ve Ceylanpınar hatlarında sabit servisimiz var. Suruç, Birecik, Halfeti gibi ilçelerde ise özel hat talebi karşılıyoruz.'],
        ]
    ],
    'personel' => [
        'label' => 'Personel Servisi',
        'icon'  => '◉',
        'iconCls' => 'o',
        'items' => [
            ['Servisim gecikirse ne olur?', 'Her aracımızda GPS var; gecikme anında koordinatörümüz kurum yetkilisini otomatik olarak arar. Ortalama gecikme süremiz aylık 2 dakikanın altındadır; %99.8 zamanında servis oranını burada tutuyoruz.'],
            ['Aracın bakımı sırasında ne oluyor?', 'Filomuzda her tipte yedek araç bulunuyor; planlı bakım sırasında hizmet aksamaz. Arıza durumunda 30 dakika içinde yedek aracımız güzergâha girer — sözleşme SLA garantimizdir.'],
            ['Minimum kaç personel için sözleşme yaparsınız?', 'Personel servisi için minimum 15 kişilik grup arıyoruz. Daha küçük gruplar için VIP van transfer hizmeti önerebiliriz.'],
            ['Aylık rapor içeriği nedir?', 'Her ayın sonunda size özel rapor gönderiyoruz: servis kalkış saatleri, dakikalık gecikme kayıtları, GPS güzergâh doğrulaması, sürücü değişiklikleri, memnuniyet notu. Kurum İK süreçlerinize entegre çalışır.'],
        ]
    ],
    'ogrenci' => [
        'label' => 'Öğrenci Servisi',
        'icon'  => '◈',
        'iconCls' => 'g',
        'items' => [
            ['MEB onayınız var mı?', 'Evet, firmamız MEB Onaylı Servis Firması statüsündedir. Yıllık denetimlerden geçer, tüm sürücülerimiz ve rehberlerimiz sicil belgeli.'],
            ['Her araçta rehber var mı?', 'Evet, öğrenci servisinde her araçta profesyonel bir rehber görev yapar. Rehberlerimiz gıda hijyeni, ilk yardım ve çocuk psikolojisi eğitimlerinden geçmiştir.'],
            ['Veli takip uygulaması nasıl çalışıyor?', 'Aileler kendi telefonlarından çocuklarının servisinin nerede olduğunu anlık görebilir. Servisin durakta olması, çocuğun binmesi ve okula ulaşması bildirim olarak düşer.'],
            ['Öğrenci sayacı nasıl doğrulanıyor?', 'Rehber her sabah öğrenciyi binmede, öğleden sonra inmede dijital olarak kaydeder. Herhangi bir eksiklik anında koordinatörümüze ve okul idaresine bildirilir.'],
            ['Yaz döneminde ne oluyor?', 'Eğitim-öğretim tatilinde servisler durur. Yaz okulu ya da özel etüt programları için ekstra hat açabiliriz — ihtiyaç sayısına göre.'],
        ]
    ],
    'filo' => [
        'label' => 'Filo & Sürücü',
        'icon'  => '✦',
        'iconCls' => 'd',
        'items' => [
            ['Kaç araçlık filonuz var?', 'Şu an aktif 47 araçlık filomuz var: 18 Sprinter, 14 Midibüs, 9 Otobüs ve 6 VIP Van. Ortalama araç yaşımız 4.'],
            ['Sürücüler kaç yıl deneyimli?', 'Sürücü kadromuzun ortalama deneyim yılı 8. Hepsi SRC belgeli, psikoteknik onaylı, yıllık sağlık taramasından geçer.'],
            ['Araç bakım sıklığı nedir?', 'Her araç 15.000 km\'de bir periyodik bakıma girer. Muayene tarihleri, sigorta yenilemeleri panele işlenir — hiçbir araç geçerli belgeleri olmadan yola çıkmaz.'],
            ['GPS kayıtları saklanıyor mu?', 'Evet, tüm GPS verileri 6 ay saklanır. Ayrıca iç ve dış kamera kayıtları 30 gün arşivlenir — kurumsal talep halinde paylaşılır.'],
        ]
    ],
    'teklif' => [
        'label' => 'Fiyat & Teklif',
        'icon'  => '◉',
        'iconCls' => 'g',
        'items' => [
            ['Teklif almak ne kadar sürer?', 'Ortalama yanıt süremiz 12 dakika. Standart bir güzergâh için 1 saat içinde detaylı teklifle dönüyoruz. Karmaşık çoklu-güzergâh planlaması için 24 saat içinde fizibiliteyle döneriz.'],
            ['Fiyatlar neye göre değişir?', 'Ana faktörler: güzergâh mesafesi, günlük yolcu sayısı, tercih edilen araç tipi, sözleşme süresi ve ek hizmetler (rehber, kamera, aylık raporlama). Şeffaf fiyatlandırma — sürprizli kalem yok.'],
            ['İndirim yapıyor musunuz?', 'Uzun süreli sözleşmelerde (12 ay+) ve çoklu kurum indirimlerimiz var. Ayrıca eğitim yılı sözleşmelerinde erken tercih avantajı sunuyoruz.'],
            ['Ödeme koşullarınız nasıl?', 'Kurumsal müşteriler için ay sonu faturalandırma standarttır. 30 gün vade tercih edilir. Peşin ödemede %2 indirim uygulanır.'],
        ]
    ],
];

$totalFaqs = array_sum(array_map(fn($c) => count($c['items']), $faqCategories));
?>

<!-- ============ PAGE HERO ============ -->
<section class="page-hero">
    <div class="wrap">
        <div class="eyebrow-light">
            <span class="year-pill"><?= (int) $totalFaqs ?> soru</span>
            <span><?= count($faqCategories) ?> kategori · Aranabilir</span>
        </div>
        <h1>Aklınıza takılanlar.<br><span class="accent">Cevaplar burada.</span></h1>
        <p class="sub">Sık sorulan soruları kategoriye göre topladık. Bulamadığınız bir sorunuz varsa aşağıdaki iletişim kutusundan direkt bize yazın — ortalama 12 dakika içinde dönüyoruz.</p>
    </div>
</section>

<!-- ============ FAQ CONTENT ============ -->
<section class="block reveal">
    <div class="wrap">

        <!-- Arama kutusu -->
        <form class="route-search" style="max-width:820px;margin-bottom:36px" onsubmit="event.preventDefault(); filterFaqs(document.getElementById('faqSearch').value);">
            <span class="search-ico">🔍</span>
            <input type="text" id="faqSearch" placeholder="Bir kelimeyle arayın — örn: 'sigorta', 'gecikme', 'MEB', 'ödeme'..."
                   oninput="filterFaqs(this.value)">
            <button type="submit">Ara</button>
        </form>

        <div class="faq-layout">
            <!-- Sidebar: kategori filter -->
            <aside class="faq-sidebar">
                <h4>Kategoriler</h4>
                <ul class="faq-cat-list" id="faqCats">
                    <li>
                        <button class="active" data-cat="all">
                            <span>Tümü</span>
                            <span class="cat-cnt"><?= (int) $totalFaqs ?></span>
                        </button>
                    </li>
                    <?php foreach ($faqCategories as $key => $cat): ?>
                    <li>
                        <button data-cat="<?= e($key) ?>">
                            <span><?= e($cat['label']) ?></span>
                            <span class="cat-cnt"><?= count($cat['items']) ?></span>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </aside>

            <!-- Content: gruplu SSS'ler -->
            <div class="faq-content" id="faqContent">
                <?php foreach ($faqCategories as $key => $cat): ?>
                <section class="faq-group" data-cat="<?= e($key) ?>">
                    <div class="faq-group-head">
                        <div class="faq-group-icon <?= e($cat['iconCls']) ?>"><?= e($cat['icon']) ?></div>
                        <h3 class="faq-group-title"><?= e($cat['label']) ?></h3>
                        <span class="faq-group-meta"><?= count($cat['items']) ?> soru</span>
                    </div>
                    <?php foreach ($cat['items'] as $i => $qa):
                        $searchText = mb_strtolower($qa[0] . ' ' . $qa[1], 'UTF-8');
                    ?>
                    <details class="faq" <?= ($key === 'genel' && $i === 0) ? 'open' : '' ?>
                             data-search="<?= e($searchText) ?>">
                        <summary><?= e($qa[0]) ?></summary>
                        <div class="faq-body"><?= e($qa[1]) ?></div>
                    </details>
                    <?php endforeach; ?>
                </section>
                <?php endforeach; ?>

                <div class="faq-no-results" id="faqNoResults">
                    <i>🔍</i>
                    <h4>Aramanızla eşleşen soru bulunamadı</h4>
                    <p>Farklı bir kelime deneyin ya da aşağıdaki iletişim kutusundan direkt sorun.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ CONTACT SPOTLIGHT ============ -->
<?php
$phone = $c['contact_phone'] ?? '+90 414 000 00 00';
$phoneClean = preg_replace('/\D/', '', $phone);
$waNum = preg_replace('/\D/', '', $phone);
if (!empty($waNum) && str_starts_with($waNum, '0')) $waNum = '90' . substr($waNum, 1);
$email = $c['contact_email'] ?? 'info@sahin.com.tr';
?>
<section class="block reveal">
    <div class="wrap">
        <div class="contact-spotlight">
            <div>
                <h3>Sorunuz burada yok mu?</h3>
                <p>Bize direkt yazın ya da arayın — ortalama yanıt süremiz 12 dakika. Karmaşık soru için ofise davet ediyoruz, kahvemiz her zaman hazır.</p>
            </div>
            <div class="contact-methods">
                <?php if ($waNum): ?>
                <a href="https://wa.me/<?= e($waNum) ?>" class="contact-method wa" target="_blank" rel="noopener">
                    <span class="m-ico">W</span>
                    <span>WhatsApp'tan yazın</span>
                </a>
                <?php endif; ?>
                <a href="tel:<?= e($phoneClean) ?>" class="contact-method">
                    <span class="m-ico">☎</span>
                    <span><?= e($phone) ?></span>
                </a>
                <a href="mailto:<?= e($email) ?>" class="contact-method">
                    <span class="m-ico">✉</span>
                    <span><?= e($email) ?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="cta-outer reveal">
    <div class="wrap">
        <div class="cta-glass">
            <div>
                <h2>Doğru cevabı bulduysanız,<br>şimdi teklif alalım.</h2>
                <p>Formu doldurun ya da direkt arayın. Kurumunuza en uygun teklifi bir saat içinde hazırlıyoruz.</p>
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
// Kategori filter + search combine
(function () {
    const cats = document.querySelectorAll('#faqCats button');
    const groups = document.querySelectorAll('#faqContent .faq-group');
    const faqs = document.querySelectorAll('#faqContent .faq');
    const noResults = document.getElementById('faqNoResults');
    let currentCat = 'all';
    let currentSearch = '';

    function apply() {
        let anyVisible = false;

        // Once tum faq'lerin search match'ini kontrol et
        faqs.forEach(f => {
            const searchMatch = !currentSearch || (f.getAttribute('data-search') || '').includes(currentSearch);
            f.classList.toggle('hidden', !searchMatch);
        });

        // Sonra grup gorunurlugu: cat match + icinde en az bir gorunen faq varsa goster
        groups.forEach(g => {
            const catMatch = currentCat === 'all' || g.getAttribute('data-cat') === currentCat;
            const hasVisible = Array.from(g.querySelectorAll('.faq')).some(f => !f.classList.contains('hidden'));
            const show = catMatch && hasVisible;
            g.classList.toggle('hidden', !show);
            if (show) anyVisible = true;
        });

        noResults.classList.toggle('on', !anyVisible);
    }

    cats.forEach(c => c.addEventListener('click', () => {
        cats.forEach(x => x.classList.remove('active'));
        c.classList.add('active');
        currentCat = c.getAttribute('data-cat');
        apply();
    }));

    window.filterFaqs = function (q) {
        currentSearch = (q || '').toLowerCase().trim();
        apply();
    };
})();
</script>
