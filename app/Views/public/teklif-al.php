<?php
/**
 * Teklif Al sayfası.
 * $company
 */
$c = $company ?? [];
$phone = $c['contact_phone'] ?? '+90 414 000 00 00';
$phoneClean = preg_replace('/\D/', '', $phone);
$waNum = $phoneClean;
if (!empty($waNum) && str_starts_with($waNum, '0')) $waNum = '90' . substr($waNum, 1);

$successMsg = flash('success');
$errorMsg   = flash('error');
?>

<!-- ============ PAGE HERO ============ -->
<section class="page-hero">
    <div class="wrap">
        <div class="eyebrow-light">
            <span class="year-pill">1 saat</span>
            <span>Detaylı teklif · Şeffaf fiyatlandırma</span>
        </div>
        <h1>Anlık teklif hesaplayıcı,<br><span class="accent">bir saatte kesin fiyat.</span></h1>
        <p class="sub">Aşağıdaki formu doldurdukça sağdaki panelde tahmini fiyat aralığı canlı hesaplanır. Kesin teklifi bir saat içinde size özel hazırlayıp gönderiyoruz.</p>
    </div>
</section>

<!-- ============ QUOTE FORM ============ -->
<section class="block reveal" id="form">
    <div class="wrap">
        <div class="quote-layout">

            <!-- SOL: form -->
            <div class="quote-form-wrap">
                <?php if ($successMsg): ?>
                <div class="form-flash success" style="margin-bottom:20px">
                    <span class="ico">✓</span>
                    <span><?= e($successMsg) ?></span>
                </div>
                <?php elseif ($errorMsg): ?>
                <div class="form-flash error" style="margin-bottom:20px">
                    <span class="ico">!</span>
                    <span><?= e($errorMsg) ?></span>
                </div>
                <?php endif; ?>

                <form action="<?= url('/teklif-al') ?>" method="POST" id="quoteForm">

                    <!-- STEP 1: Hizmet Tipi -->
                    <div class="quote-step">
                        <div class="quote-step-head">
                            <span class="quote-step-num">01</span>
                            <div>
                                <div class="quote-step-title">Hangi hizmeti düşünüyorsunuz?</div>
                                <div class="quote-step-sub">Kart seçimi fiyat tahmininizi etkiler.</div>
                            </div>
                        </div>

                        <div class="service-picker">
                            <label class="service-radio selected" data-svc="personel">
                                <input type="radio" name="service" value="personel" checked>
                                <div class="ico">◈</div>
                                <div class="label">Personel Servisi</div>
                                <div class="hint">Fabrika · Ofis · OSB</div>
                            </label>
                            <label class="service-radio ogr" data-svc="ogrenci">
                                <input type="radio" name="service" value="ogrenci">
                                <div class="ico">◉</div>
                                <div class="label">Öğrenci Servisi</div>
                                <div class="hint">Okul · MEB standardı</div>
                            </label>
                            <label class="service-radio tur" data-svc="tur">
                                <input type="radio" name="service" value="tur">
                                <div class="ico">✦</div>
                                <div class="label">Tur & Transfer</div>
                                <div class="hint">Grup · Havalimanı · Düğün</div>
                            </label>
                        </div>
                    </div>

                    <!-- STEP 2: Guzergah -->
                    <div class="quote-step">
                        <div class="quote-step-head">
                            <span class="quote-step-num">02</span>
                            <div>
                                <div class="quote-step-title">Güzergâh</div>
                                <div class="quote-step-sub">Kalkış ve varış noktası (semt/kurum adı yeter).</div>
                            </div>
                        </div>

                        <div class="qf-row">
                            <div class="qf-group">
                                <label>Nereden <span class="req">*</span></label>
                                <input type="text" name="from" required placeholder="Ör. Karaköprü Merkez">
                            </div>
                            <div class="qf-group">
                                <label>Nereye <span class="req">*</span></label>
                                <input type="text" name="to" required placeholder="Ör. İpekyol OSB">
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: Detaylar -->
                    <div class="quote-step">
                        <div class="quote-step-head">
                            <span class="quote-step-num">03</span>
                            <div>
                                <div class="quote-step-title">Detaylar</div>
                                <div class="quote-step-sub">Kişi sayısı, kullanım, süre — bu üçü fiyatı belirler.</div>
                            </div>
                        </div>

                        <div class="qf-row three">
                            <div class="qf-group">
                                <label>Kişi sayısı <span class="req">*</span></label>
                                <input type="number" name="people" id="peopleInput" min="1" max="500" value="30" required>
                            </div>
                            <div class="qf-group">
                                <label>Kullanım</label>
                                <select name="frequency" id="freqInput">
                                    <option value="both" selected>Sabah + Akşam</option>
                                    <option value="one">Tek yön</option>
                                    <option value="shift">3 vardiya</option>
                                </select>
                            </div>
                            <div class="qf-group">
                                <label>Süre</label>
                                <select name="duration" id="durInput">
                                    <option value="3">3 aylık</option>
                                    <option value="6">6 aylık</option>
                                    <option value="12" selected>12 aylık</option>
                                    <option value="edu">Eğitim yılı (10 ay)</option>
                                    <option value="once">Tek seferlik</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: Ek hizmetler -->
                    <div class="quote-step">
                        <div class="quote-step-head">
                            <span class="quote-step-num">04</span>
                            <div>
                                <div class="quote-step-title">Ek hizmetler (opsiyonel)</div>
                                <div class="quote-step-sub">GPS ve sigorta zaten dahil. Bunları ekleyebilirsiniz.</div>
                            </div>
                        </div>

                        <div class="addon-grid">
                            <label class="addon-check">
                                <input type="checkbox" name="addon_guide" value="1" data-price="5">
                                <span class="a-label">Rehber refakati</span>
                                <span class="a-meta">+%5</span>
                            </label>
                            <label class="addon-check">
                                <input type="checkbox" name="addon_report" value="1" data-price="3">
                                <span class="a-label">Aylık raporlama</span>
                                <span class="a-meta">+%3</span>
                            </label>
                            <label class="addon-check">
                                <input type="checkbox" name="addon_backup" value="1" data-price="4">
                                <span class="a-label">Yedek araç garantisi</span>
                                <span class="a-meta">+%4</span>
                            </label>
                            <label class="addon-check">
                                <input type="checkbox" name="addon_vip" value="1" data-price="20">
                                <span class="a-label">VIP araç yükseltme</span>
                                <span class="a-meta">+%20</span>
                            </label>
                        </div>
                    </div>

                    <!-- STEP 5: Iletisim -->
                    <div class="quote-step">
                        <div class="quote-step-head">
                            <span class="quote-step-num">05</span>
                            <div>
                                <div class="quote-step-title">Sizinle nasıl iletişime geçelim?</div>
                                <div class="quote-step-sub">Bu bilgilerle 1 saat içinde döneceğiz.</div>
                            </div>
                        </div>

                        <div class="qf-row">
                            <div class="qf-group">
                                <label>Ad Soyad <span class="req">*</span></label>
                                <input type="text" name="name" required placeholder="Ör. Ahmet Yılmaz">
                            </div>
                            <div class="qf-group">
                                <label>Telefon <span class="req">*</span></label>
                                <input type="tel" name="phone" required placeholder="0 555 123 45 67">
                            </div>
                        </div>

                        <div class="qf-row">
                            <div class="qf-group">
                                <label>E-posta</label>
                                <input type="email" name="email" placeholder="mail@sirket.com">
                            </div>
                            <div class="qf-group">
                                <label>Kurum</label>
                                <input type="text" name="company" placeholder="Şirket / okul adı">
                            </div>
                        </div>

                        <div class="qf-group">
                            <label>Not (opsiyonel)</label>
                            <textarea name="note" placeholder="Özel isteğiniz varsa buraya yazın..."></textarea>
                        </div>
                    </div>

                </form>
            </div>

            <!-- SAG: sticky preview panel -->
            <aside>
                <div class="quote-preview">
                    <div class="qp-eyebrow">Canlı Tahmin</div>
                    <div class="qp-title" id="qpTitle">Personel Servisi · 30 kişi</div>
                    <div class="qp-price">
                        <span id="qpLow">24.000</span>
                        <span class="to">→</span>
                        <span id="qpHigh">28.800</span>
                        <span class="unit">TL/ay</span>
                    </div>
                    <div class="qp-range-label" id="qpRangeLabel">tahmini aylık maliyet</div>

                    <div class="qp-breakdown">
                        <div class="qp-line">
                            <span class="name">◈ Baz fiyat / kişi</span>
                            <span class="val" id="qpBase">800 TL</span>
                        </div>
                        <div class="qp-line">
                            <span class="name">◉ Kişi sayısı</span>
                            <span class="val" id="qpPeople">× 30</span>
                        </div>
                        <div class="qp-line" id="qpFreqLine">
                            <span class="name">🕒 Kullanım</span>
                            <span class="val" id="qpFreq">Sabah + Akşam</span>
                        </div>
                        <div class="qp-line" id="qpDurLine">
                            <span class="name">📆 Sözleşme</span>
                            <span class="val" id="qpDur">12 aylık (-%5)</span>
                        </div>
                        <div class="qp-line" id="qpAddonsLine" style="display:none">
                            <span class="name">✦ Ek hizmetler</span>
                            <span class="val" id="qpAddons">+%0</span>
                        </div>
                        <div class="qp-line total">
                            <span class="name">Toplam tahmin</span>
                            <span class="val" id="qpTotal">24.000 – 28.800 TL/ay</span>
                        </div>
                    </div>

                    <div class="qp-note">
                        <b>Not:</b> Bu tahmin bilgi amaçlıdır. Kesin fiyatı güzergâh mesafesi, saat aralığı ve araç tipini değerlendirdikten sonra size özel çıkarırız.
                    </div>

                    <button type="submit" form="quoteForm" class="qp-cta">
                        Detaylı teklif için gönder →
                    </button>
                    <div class="qp-alt">
                        Ya da direkt arayın · <a href="tel:<?= e($phoneClean) ?>"><?= e($phone) ?></a>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</section>

<!-- ============ NASIL ÇALIŞIYOR (3 adım) ============ -->
<section class="block reveal" style="background:var(--bg-2)">
    <div class="wrap">
        <div class="section-head" style="margin-left:auto;margin-right:auto;text-align:center">
            <div class="eyebrow">Sürecimiz</div>
            <h2 class="title">Formdan sözleşmeye 3 adım.</h2>
            <p class="section-lede" style="margin-left:auto;margin-right:auto">Anlık form, hızlı geri dönüş, net süreç.</p>
        </div>

        <div class="process-grid" style="grid-template-columns:repeat(3,1fr)">
            <div class="process-step">
                <div class="process-num">01</div>
                <div class="process-title">Formu doldurun</div>
                <div class="process-desc">Yandaki formu 2 dakikada bitirin. Sağdaki panelde tahmini fiyatı anında görün.</div>
                <span class="process-time">~ 2 dk</span>
            </div>
            <div class="process-step">
                <div class="process-num">02</div>
                <div class="process-title">1 saat içinde arayalım</div>
                <div class="process-desc">Talebiniz koordinatörümüze düşer. Detaylı hesaplama + araç önerisi ile telefonla döneriz.</div>
                <span class="process-time">~ 1 saat</span>
            </div>
            <div class="process-step">
                <div class="process-num">03</div>
                <div class="process-title">Sözleşme + servis başlar</div>
                <div class="process-desc">Anlaşırsak sözleşme hazırlanır, imzalar tamamlanır, servis 1 hafta içinde başlar.</div>
                <span class="process-time">~ 1 hafta</span>
            </div>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="cta-outer reveal">
    <div class="wrap">
        <div class="cta-glass">
            <div>
                <h2>Formu bitirmediniz mi?<br>Direkt konuşalım.</h2>
                <p>Bazı işler telefonda daha hızlı ilerler. Aradığınız an koordinatörümüz açar.</p>
            </div>
            <div class="cta-glass-actions">
                <a class="btn btn-indigo btn-lg" href="https://wa.me/<?= e($waNum) ?>" target="_blank" rel="noopener">WhatsApp'tan yaz →</a>
                <a class="cta-phone" href="tel:<?= e($phoneClean) ?>">
                    <span>Ya da direkt arayın:</span>
                    <span class="num"><?= e($phone) ?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
// ============ CANLI TAHMİN HESAPLAYICI ============
(function () {
    // Baz fiyatlar (kisi/ay)
    const basePrices = {
        personel: 800,
        ogrenci:  750,
        tur:      3500, // Flat estimate (kisi bazli degil)
    };
    const serviceLabels = {
        personel: 'Personel Servisi',
        ogrenci:  'Öğrenci Servisi',
        tur:      'Tur & Transfer',
    };
    const freqLabels = {
        both:  'Sabah + Akşam',
        one:   'Tek yön',
        shift: '3 vardiya',
    };
    const freqMult = { both: 1, one: 0.65, shift: 1.6 };
    const durDiscount = { '3': 0, '6': 0.03, '12': 0.05, 'edu': 0.04, 'once': 0 };
    const durLabel = { '3': '3 aylık', '6': '6 aylık (-%3)', '12': '12 aylık (-%5)', 'edu': 'Eğitim yılı (-%4)', 'once': 'Tek seferlik' };

    // Service picker
    const radios = document.querySelectorAll('.service-radio');
    radios.forEach(r => r.addEventListener('click', () => {
        radios.forEach(x => x.classList.remove('selected'));
        r.classList.add('selected');
        r.querySelector('input').checked = true;
        recalc();
    }));

    // Addon checkboxes
    document.querySelectorAll('.addon-check').forEach(a => {
        a.addEventListener('change', () => {
            a.classList.toggle('checked', a.querySelector('input').checked);
            recalc();
        });
    });

    // Number/select inputs
    ['peopleInput', 'freqInput', 'durInput'].forEach(id => {
        document.getElementById(id).addEventListener('input', recalc);
        document.getElementById(id).addEventListener('change', recalc);
    });

    function recalc() {
        const svc = document.querySelector('input[name="service"]:checked').value;
        const people = Math.max(1, parseInt(document.getElementById('peopleInput').value) || 1);
        const freq = document.getElementById('freqInput').value;
        const dur = document.getElementById('durInput').value;

        let baseTotal;
        if (svc === 'tur') {
            baseTotal = basePrices.tur * Math.max(1, Math.ceil(people / 15));
        } else {
            baseTotal = basePrices[svc] * people * (freqMult[freq] || 1);
        }

        // Ek hizmet yuzdeleri topla
        let addonPct = 0;
        document.querySelectorAll('.addon-check input:checked').forEach(cb => {
            addonPct += parseInt(cb.getAttribute('data-price')) || 0;
        });
        const withAddons = baseTotal * (1 + addonPct / 100);

        // Sozlesme indirimi
        const discount = durDiscount[dur] || 0;
        const midEstimate = withAddons * (1 - discount);

        // Range: -10% / +20%
        const low  = Math.round(midEstimate * 0.90 / 100) * 100;
        const high = Math.round(midEstimate * 1.20 / 100) * 100;

        // Format
        const fmt = n => n.toLocaleString('tr-TR');
        const unit = (svc === 'tur') ? (dur === 'once' ? 'TL' : 'TL/ay') : 'TL/ay';

        // DOM guncelle
        document.getElementById('qpTitle').textContent = `${serviceLabels[svc]} · ${people} kişi`;
        document.getElementById('qpLow').textContent = fmt(low);
        document.getElementById('qpHigh').textContent = fmt(high);
        document.getElementById('qpRangeLabel').textContent = (svc === 'tur' && dur === 'once') ? 'tahmini toplam maliyet' : 'tahmini aylık maliyet';
        document.querySelectorAll('.qp-price .unit').forEach(el => el.textContent = unit);

        document.getElementById('qpBase').textContent = (svc === 'tur') ? '3.500 TL/set' : fmt(basePrices[svc]) + ' TL';
        document.getElementById('qpPeople').textContent = '× ' + people;
        document.getElementById('qpFreq').textContent = freqLabels[freq];
        document.getElementById('qpDur').textContent = durLabel[dur];

        const addonsLine = document.getElementById('qpAddonsLine');
        if (addonPct > 0) {
            addonsLine.style.display = 'flex';
            document.getElementById('qpAddons').textContent = '+%' + addonPct;
        } else {
            addonsLine.style.display = 'none';
        }

        document.getElementById('qpTotal').textContent = `${fmt(low)} – ${fmt(high)} ${unit}`;
    }

    recalc();
})();
</script>
