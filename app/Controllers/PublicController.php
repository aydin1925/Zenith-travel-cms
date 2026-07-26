<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\TelegramNotifier;
use App\Models\Institution;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Message;

/**
 * Public site controller.
 * Simdilik yalnizca home() gercek icerik render eder;
 * diger sayfalar coming-soon placeholder'a dusuyor
 * (sirayla ekleyecegiz).
 */
class PublicController extends Controller
{
    /** Ortak layout data'si (nav & footer sirket bilgilerini kullanir) */
    private function baseData(): array
    {
        $company = Setting::get();
        $founded = !empty($company['founded_year']) ? (int) $company['founded_year'] : 2003;
        return [
            'company'     => $company,
            'foundedYear' => $founded,
            'yearsInBiz'  => (int) date('Y') - $founded,
        ];
    }

    /** GET / */
    public function home(Request $request): void
    {
        $vehicleCount     = Vehicle::count();
        $institutionCount = Institution::count();
        $serviceCount     = Service::count();

        // Filo turlerine gore sayilar — vehicles.type kolonundan direkt
        $fleetTotals = Vehicle::countByType();

        // Yaklasik gunluk yolcu = ortalama arac x kapasite. Statik oran.
        $dailyPassengers = max(1850, $vehicleCount * 40);

        $data = $this->baseData() + [
            'stats' => [
                'institutions'     => $institutionCount,
                'vehicles'         => $vehicleCount,
                'services'         => $serviceCount,
                'daily_passengers' => $dailyPassengers,
            ],
            'references'  => Institution::all(),
            'fleetTotals' => $fleetTotals,
            'activePage'  => 'home',
            'pageTitle'   => 'Sahin Tasimacilik — Sanliurfa Personel & Ogrenci Servisi',
        ];

        $this->view('public/home', $data, 'layouts/public');
    }

    /** GET /teklif-al */
    public function quote(Request $request): void
    {
        $data = $this->baseData() + [
            'activePage' => 'teklif-al',
            'pageTitle'  => 'Teklif Al — Sahin Tasimacilik',
        ];
        $this->view('public/teklif-al', $data, 'layouts/public');
    }

    /** POST /teklif-al — teklif talebini DB'ye yazar */
    public function quoteSubmit(Request $request): void
    {
        $name    = trim((string) $request->input('name', ''));
        $phone   = trim((string) $request->input('phone', ''));
        $service = trim((string) $request->input('service', 'personel'));

        if ($name === '' || $phone === '') {
            flash('error', 'Ad ve telefon zorunludur.');
            $this->redirect('/teklif-al#form');
        }

        $serviceLabel = ['personel' => 'Personel Servisi', 'ogrenci' => 'Öğrenci Servisi', 'tur' => 'Tur & Transfer'][$service] ?? 'Genel';

        // Form'un tum secim verilerini JSON olarak sakla
        $formData = [
            'service'      => $service,
            'from'         => trim((string) $request->input('from', '')),
            'to'           => trim((string) $request->input('to', '')),
            'people'       => (int) $request->input('people', 0),
            'frequency'    => (string) $request->input('frequency', ''),
            'duration'     => (string) $request->input('duration', ''),
            'addon_guide'  => $request->input('addon_guide')  ? '1' : '0',
            'addon_report' => $request->input('addon_report') ? '1' : '0',
            'addon_backup' => $request->input('addon_backup') ? '1' : '0',
            'addon_vip'    => $request->input('addon_vip')    ? '1' : '0',
            'note'         => trim((string) $request->input('note', '')),
        ];

        $msgData = [
            'source'    => 'quote',
            'name'      => $name,
            'phone'     => $phone,
            'email'     => trim((string) $request->input('email', '')) ?: null,
            'company'   => trim((string) $request->input('company', '')) ?: null,
            'subject'   => 'Teklif Talebi: ' . $serviceLabel,
            'message'   => $formData['note'] ?: null,
            'form_data' => $formData,
        ];
        $msgId = Message::create($msgData);

        // Telegram bildirimi (env bos ise sessizce atlar)
        TelegramNotifier::notifyQuote($msgData, $formData, $msgId);

        flash('success', "Teklif talebiniz alındı $name. $serviceLabel için 1 saat içinde detaylı teklifle döneceğiz.");
        $this->redirect('/teklif-al#form');
    }

    /** GET /iletisim */
    public function contact(Request $request): void
    {
        $data = $this->baseData() + [
            'activePage' => 'iletisim',
            'pageTitle'  => 'İletişim — Sahin Tasimacilik',
        ];
        $this->view('public/iletisim', $data, 'layouts/public');
    }

    /** POST /iletisim — mesajı DB'ye yazar */
    public function contactSubmit(Request $request): void
    {
        $name    = trim((string) $request->input('name', ''));
        $phone   = trim((string) $request->input('phone', ''));

        if ($name === '' || $phone === '') {
            flash('error', 'Ad ve telefon zorunludur.');
            $this->redirect('/iletisim#form');
        }

        $msgData = [
            'source'  => 'contact',
            'name'    => $name,
            'phone'   => $phone,
            'email'   => trim((string) $request->input('email', '')) ?: null,
            'company' => trim((string) $request->input('company', '')) ?: null,
            'subject' => trim((string) $request->input('subject', 'Genel bilgi')),
            'message' => trim((string) $request->input('message', '')) ?: null,
        ];
        $msgId = Message::create($msgData);

        // Telegram bildirimi (env bos ise sessizce atlar)
        TelegramNotifier::notifyContact($msgData, $msgId);

        flash('success', "Mesajınız iletildi $name. En kısa sürede size dönüş yapacağız.");
        $this->redirect('/iletisim#form');
    }

    /** GET /sss */
    public function faq(Request $request): void
    {
        $data = $this->baseData() + [
            'activePage' => 'sss',
            'pageTitle'  => 'Sıkça Sorulan Sorular — Sahin Tasimacilik',
        ];
        $this->view('public/sss', $data, 'layouts/public');
    }

    /** GET /hizmetlerimiz */
    public function services(Request $request): void
    {
        $data = $this->baseData() + [
            'stats' => [
                'institutions' => Institution::count(),
                'vehicles'     => Vehicle::count(),
            ],
            'activePage' => 'hizmetlerimiz',
            'pageTitle'  => 'Hizmetlerimiz — Sahin Tasimacilik',
        ];

        $this->view('public/hizmetlerimiz', $data, 'layouts/public');
    }

    /** GET /referanslarimiz */
    public function references(Request $request): void
    {
        $institutions = Institution::all();

        // Tipe gore say
        $typeCounts = ['Okul' => 0, 'Sirket' => 0, 'Acente' => 0, 'Diger' => 0];
        foreach ($institutions as $i) {
            $t = $i['type'] ?? 'Diger';
            if (isset($typeCounts[$t])) $typeCounts[$t]++;
            else $typeCounts['Diger']++;
        }

        $data = $this->baseData() + [
            'institutions' => $institutions,
            'typeCounts'   => $typeCounts,
            'total'        => count($institutions),
            'activePage'   => 'referanslarimiz',
            'pageTitle'    => 'Referanslarımız — Sahin Tasimacilik',
        ];

        $this->view('public/referanslarimiz', $data, 'layouts/public');
    }

    /** GET /rotalar */
    public function routes(Request $request): void
    {
        $services = Service::allWithRelations();

        // service_type'a gore say (Personel/Ogrenci/Ozel)
        $typeCounts = ['personel' => 0, 'ogrenci' => 0, 'ozel' => 0];
        foreach ($services as $s) {
            $t = mb_strtolower($s['service_type'] ?? '', 'UTF-8');
            if (str_contains($t, 'personel')) $typeCounts['personel']++;
            elseif (str_contains($t, 'ogrenci') || str_contains($t, 'öğrenci')) $typeCounts['ogrenci']++;
            else $typeCounts['ozel']++;
        }

        $data = $this->baseData() + [
            'services'   => $services,
            'typeCounts' => $typeCounts,
            'total'      => count($services),
            'activePage' => 'rotalar',
            'pageTitle'  => 'Rotalar — Sahin Tasimacilik',
        ];

        $this->view('public/rotalar', $data, 'layouts/public');
    }

    /** GET /filo — tum filo listesi */
    public function fleet(Request $request): void
    {
        $data = $this->baseData() + [
            'vehicles'    => Vehicle::all(),
            'categorized' => Vehicle::countByType(),
            'total'       => count(Vehicle::all()),
            'activePage'  => 'filo',
            'pageTitle'   => 'Filomuz — Sahin Tasimacilik',
        ];

        $this->view('public/filo', $data, 'layouts/public');
    }

    /** GET /hakkimizda */
    public function about(Request $request): void
    {
        // baseData zaten foundedYear + yearsInBiz'i settings'ten hesapliyor
        $data = $this->baseData() + [
            'stats' => [
                'institutions' => Institution::count(),
                'vehicles'     => Vehicle::count(),
                'services'     => Service::count(),
            ],
            'activePage' => 'hakkimizda',
            'pageTitle'  => 'Hakkımızda — Sahin Tasimacilik',
        ];

        $this->view('public/hakkimizda', $data, 'layouts/public');
    }

    /** Diger nav linkleri icin generic placeholder */
    public function comingSoon(Request $request): void
    {
        $path = trim($request->path, '/');
        $pageNames = [
            'hakkimizda'      => 'Hakkımızda',
            'hizmetlerimiz'   => 'Hizmetlerimiz',
            'filo'            => 'Filomuz',
            'rotalar'         => 'Rotalarımız',
            'referanslarimiz' => 'Referanslarımız',
            'sss'             => 'Sıkça Sorulan Sorular',
            'iletisim'        => 'İletişim',
            'teklif-al'       => 'Teklif Al',
        ];
        $pageName = $pageNames[$path] ?? 'Bu sayfa';

        $data = $this->baseData() + [
            'pageName'   => $pageName,
            'activePage' => $path,
            'pageTitle'  => $pageName . ' — Sahin Tasimacilik',
        ];

        $this->view('public/coming-soon', $data, 'layouts/public');
    }
}
