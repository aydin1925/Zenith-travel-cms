<p align="center">
  <img src="https://img.shields.io/badge/Zenith-CMS-0D1117?style=for-the-badge&labelColor=0D1117&color=58A6FF" alt="Zenith CMS" />
</p>

<h1 align="center">Zenith</h1>

<p align="center">
  <strong>B2B Turizm & Taşımacılık Yönetim Paneli</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-≥8.1-777BB4?style=flat-square&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Composer-885630?style=flat-square&logo=composer&logoColor=white" />
  <img src="https://img.shields.io/badge/License-Proprietary-0D1117?style=flat-square" />
</p>

<p align="center">
  <sub>Kurumsal turizm ve personel taşımacılığı firmaları için geliştirilen hafif, hızlı ve ölçeklenebilir CMS.</sub>
</p>

---

## Hakkında

**Zenith**, sıfırdan yazılmış özel bir PHP framework üzerinde çalışan, B2B turizm ve taşımacılık sektörüne özel içerik yönetim sistemidir. Harici framework bağımlılığı olmadan; kendi Router, Controller, Middleware ve Model katmanlarıyla çalışır.

> Hız, sadelik ve güvenlik — üçünü birlikte sunar.

---

## Özellikler

| Modül | Açıklama |
|---|---|
| **Kurumsal Site** | Hakkımızda, hizmetler, filo, rotalar, referanslar, SSS, iletişim ve teklif alma sayfaları |
| **Admin Paneli** | Dashboard, kurum yönetimi, araç filosu, hizmet tanımları, mesaj kutusu, site ayarları |
| **Mesajlaşma** | İletişim formu + teklif formu ile gelen mesajların admin panelden yönetimi |
| **Telegram** | Yeni mesaj ve teklif geldiğinde anlık Telegram bot bildirimi |
| **Kimlik Doğrulama** | Session tabanlı login sistemi, Auth & Guest middleware koruması |
| **Dosya Yükleme** | Araç görselleri ve kurum logoları için güvenli dosya yükleme |

---

## Teknoloji

```
PHP 8.1+          → Strict types, union types, named arguments
Custom MVC        → Kendi Router / Controller / Model / View katmanı
PDO               → Prepared statements ile veritabanı erişimi
Composer          → PSR-4 autoloading + vlucas/phpdotenv
Vanilla CSS & JS  → Framework bağımlılığı yok
```

---

## Proje Yapısı

```
Zenith/
├── app/
│   ├── Controllers/        # PublicController, AuthController
│   │   └── Admin/          # Dashboard, Institution, Vehicle, Service, Setting, Message
│   ├── Core/               # App, Router, Controller, Database, Request, FileUploader
│   ├── Helpers/            # Global yardımcı fonksiyonlar
│   ├── Middleware/          # AuthMiddleware, GuestMiddleware
│   ├── Models/             # Institution, Vehicle, Service, Setting, Message, User
│   └── Views/
│       ├── admin/          # Admin panel view'ları
│       ├── auth/           # Login sayfası
│       ├── errors/         # 404, 500 hata sayfaları
│       ├── layouts/        # Ortak layout şablonları
│       └── public/         # Kurumsal site sayfaları
├── config/
│   └── database.php        # Veritabanı konfigürasyonu (.env'den okur)
├── public/
│   ├── assets/
│   │   ├── css/            # public.css, admin_dashboard.css, admin_login.css
│   │   └── js/             # admin.js
│   ├── uploads/            # Kullanıcı yüklemeleri (git-ignored)
│   └── index.php           # Front controller (tek giriş noktası)
├── routes/
│   └── web.php             # Tüm rota tanımları
├── .env                    # Ortam değişkenleri (git-ignored)
├── .env.example            # Örnek ortam dosyası
├── composer.json           # Bağımlılıklar ve autoload
└── .htaccess               # Root → public/ yönlendirmesi
```

---

## Kurulum

**1.** Depoyu klonla

```bash
git clone https://github.com/kullanici/Zenith.git
cd Zenith
```

**2.** Bağımlılıkları yükle

```bash
composer install
```

**3.** Ortam dosyasını oluştur

```bash
cp .env.example .env
```

`.env` dosyasını düzenle:

```env
DB_HOST=localhost
DB_NAME=zenith_db
DB_USER=root
DB_PASS=

# Opsiyonel: Telegram bildirimleri
TELEGRAM_BOT_TOKEN=
TELEGRAM_CHAT_ID=
```

**4.** Veritabanını içe aktar

```bash
mysql -u root -p zenith_db < veritabani.sql
```

**5.** Apache'de çalıştır

> `mod_rewrite` aktif olmalıdır. XAMPP kullanıyorsanız projeyi `htdocs/Zenith` altına yerleştirmeniz yeterlidir.

```
http://localhost/Zenith
```

---

## Ortam Değişkenleri

| Değişken | Açıklama | Varsayılan |
|---|---|---|
| `APP_NAME` | Uygulama adı | `Zenith CMS` |
| `APP_ENV` | Ortam (local / production) | `local` |
| `APP_DEBUG` | Hata detaylarını göster | `true` |
| `APP_URL` | Temel URL | `http://localhost/Zenith` |
| `DB_HOST` | Veritabanı sunucusu | `localhost` |
| `DB_NAME` | Veritabanı adı | `zenith_db` |
| `DB_USER` | Veritabanı kullanıcısı | `root` |
| `DB_PASS` | Veritabanı şifresi | — |
| `DB_CHARSET` | Karakter seti | `utf8mb4` |
| `TELEGRAM_BOT_TOKEN` | Telegram bot token'ı | — |
| `TELEGRAM_CHAT_ID` | Telegram chat ID | — |

---

## Rota Yapısı

### Kurumsal Site

```
GET  /                  → Ana sayfa
GET  /hakkimizda        → Hakkımızda
GET  /hizmetlerimiz     → Hizmetler
GET  /filo              → Araç filosu
GET  /rotalar           → Güzergahlar
GET  /referanslarimiz   → Referanslar
GET  /sss               → Sıkça Sorulan Sorular
GET  /iletisim          → İletişim formu
POST /iletisim          → Form gönderimi
GET  /teklif-al         → Teklif formu
POST /teklif-al         → Teklif gönderimi
```

### Admin Panel `(auth middleware)`

```
GET  /admin/dashboard              → Kontrol paneli
GET  /admin/institutions           → Kurum listesi
GET  /admin/vehicles               → Araç yönetimi
GET  /admin/services               → Hizmet yönetimi
GET  /admin/settings               → Site ayarları
GET  /admin/messages               → Gelen mesajlar
```

---

## Lisans

Bu proje özel lisanslıdır. Tüm hakları saklıdır.

---

<p align="center">
  <sub>Aydin Sahin tarafından geliştirilmektedir.</sub>
</p>
