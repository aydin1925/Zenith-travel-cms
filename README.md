<div align="center">

<br/>

<img src="https://readme-typing-svg.demolab.com?font=Outfit&weight=700&size=45&pause=1000&color=58A6FF&center=true&vCenter=true&repeat=false&width=300&height=60&lines=Zenith" alt="Zenith" />

<p>
  <strong>B2B Turizm & Taşımacılık Yönetim Paneli</strong>
</p>

<p>
  <em>Kurumsal turizm ve personel taşımacılığı firmaları için<br/>sıfırdan yazılmış, hafif ve hızlı CMS.</em>
</p>

<br/>

<a href="#-kurulum"><img src="https://img.shields.io/badge/Başlangıç-58A6FF?style=for-the-badge&logoColor=white" /></a>&nbsp;
<a href="#-özellikler"><img src="https://img.shields.io/badge/Özellikler-8B5CF6?style=for-the-badge&logoColor=white" /></a>&nbsp;
<a href="#%EF%B8%8F-teknoloji"><img src="https://img.shields.io/badge/Teknoloji-EC4899?style=for-the-badge&logoColor=white" /></a>

<br/><br/>

<img src="https://img.shields.io/badge/PHP-≥8.1-777BB4?style=flat-square&logo=php&logoColor=white" />
&nbsp;
<img src="https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white" />
&nbsp;
<img src="https://img.shields.io/badge/Composer-885630?style=flat-square&logo=composer&logoColor=white" />
&nbsp;
<img src="https://img.shields.io/badge/MVC-Custom_Framework-0D1117?style=flat-square" />

<br/><br/>

<img src="https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/aqua.png" />

</div>

## 🔭 &nbsp;Hakkında

**Zenith**, harici framework bağımlılığı olmadan sıfırdan yazılmış bir PHP framework üzerinde çalışır. Kendi **Router**, **Controller**, **Middleware** ve **Model** katmanlarıyla tam bir MVC mimarisi sunar.

> [!NOTE]
> Hız, sadelik ve güvenlik — üçünü birlikte hedefler.

<br/>

## ✦ &nbsp;Özellikler

<table>
<tr>
<td width="50%">

#### 🌐 &nbsp;Kurumsal Site
- Ana sayfa, hakkımızda, hizmetler
- Araç filosu ve güzergahlar
- Referanslar ve SSS
- İletişim & teklif alma formu

</td>
<td width="50%">

#### 🛠 &nbsp;Admin Paneli
- Dashboard ile genel bakış
- Kurum ve araç yönetimi
- Hizmet tanımları
- Mesaj kutusu ve site ayarları

</td>
</tr>
<tr>
<td width="50%">

#### 🔔 &nbsp;Bildirimler
- Telegram bot entegrasyonu
- Yeni mesaj & teklif bildirimleri
- Anlık push notification

</td>
<td width="50%">

#### 🔒 &nbsp;Güvenlik
- Session tabanlı kimlik doğrulama
- Auth & Guest middleware
- PDO prepared statements
- Güvenli dosya yükleme

</td>
</tr>
</table>

<br/>

## ⚙️ &nbsp;Teknoloji

```
PHP 8.1+          Strict types · union types · named arguments
Custom MVC        Router · Controller · Model · View katmanları
PDO               Prepared statements ile veritabanı erişimi
Composer          PSR-4 autoloading · vlucas/phpdotenv
Vanilla CSS/JS    Harici frontend bağımlılığı yok
```

<br/>

## 📁 &nbsp;Proje Yapısı

```
Zenith/
│
├── app/
│   ├── Controllers/
│   │   ├── Admin/            ← Dashboard, Institution, Vehicle, Service, Setting, Message
│   │   ├── AuthController    ← Login / Logout
│   │   └── PublicController  ← Kurumsal site sayfaları
│   ├── Core/                 ← App, Router, Database, Request, FileUploader
│   ├── Helpers/              ← Global yardımcı fonksiyonlar
│   ├── Middleware/           ← Auth & Guest middleware
│   ├── Models/               ← Institution, Vehicle, Service, Setting, Message, User
│   └── Views/
│       ├── admin/            ← Panel arayüzleri
│       ├── public/           ← Kurumsal site sayfaları
│       ├── layouts/          ← Ortak şablonlar
│       └── errors/           ← 404, 500
│
├── config/
│   └── database.php          ← DB ayarları (.env'den okur)
│
├── public/
│   ├── assets/               ← CSS & JS dosyaları
│   ├── uploads/              ← Kullanıcı yüklemeleri
│   └── index.php             ← Front controller
│
├── routes/
│   └── web.php               ← Tüm rota tanımları
│
├── .env.example
├── composer.json
└── .htaccess
```

<br/>

## 🚀 &nbsp;Kurulum

> [!IMPORTANT]
> `PHP ≥ 8.1`, `MySQL`, `Composer` ve `mod_rewrite` aktif bir Apache sunucusu gereklidir.

**1** &nbsp; Depoyu klonla

```bash
git clone https://github.com/aydin1925/Zenith-travel-cms.git && cd Zenith
```

**2** &nbsp; Bağımlılıkları yükle

```bash
composer install
```

**3** &nbsp; Ortam dosyasını oluştur ve düzenle

```bash
cp .env.example .env
```

```env
DB_HOST=localhost
DB_NAME=zenith_db
DB_USER=root
DB_PASS=

# Opsiyonel
TELEGRAM_BOT_TOKEN=
TELEGRAM_CHAT_ID=
```

**4** &nbsp; Veritabanını içe aktar

```bash
mysql -u root -p zenith_db < veritabani.sql
```

**5** &nbsp; Çalıştır

```
http://localhost/Zenith
```

<br/>

## 🔀 &nbsp;Rotalar

<details>
<summary>&nbsp;<strong>Kurumsal Site</strong></summary>

<br/>

| Method | Rota | Sayfa |
|:---:|---|---|
| `GET` | `/` | Ana sayfa |
| `GET` | `/hakkimizda` | Hakkımızda |
| `GET` | `/hizmetlerimiz` | Hizmetler |
| `GET` | `/filo` | Araç filosu |
| `GET` | `/rotalar` | Güzergahlar |
| `GET` | `/referanslarimiz` | Referanslar |
| `GET` | `/sss` | SSS |
| `GET` | `/iletisim` | İletişim formu |
| `POST` | `/iletisim` | Form gönderimi |
| `GET` | `/teklif-al` | Teklif formu |
| `POST` | `/teklif-al` | Teklif gönderimi |

</details>

<details>
<summary>&nbsp;<strong>Admin Panel</strong> &nbsp;<code>auth middleware</code></summary>

<br/>

| Method | Rota | İşlev |
|:---:|---|---|
| `GET` | `/admin/dashboard` | Kontrol paneli |
| `GET` | `/admin/institutions` | Kurum yönetimi |
| `GET` | `/admin/vehicles` | Araç yönetimi |
| `GET` | `/admin/services` | Hizmet yönetimi |
| `GET` | `/admin/settings` | Site ayarları |
| `GET` | `/admin/messages` | Gelen mesajlar |

</details>

<br/>

## 📋 &nbsp;Ortam Değişkenleri

| Değişken | Açıklama | Varsayılan |
|---|---|:---:|
| `APP_NAME` | Uygulama adı | `Zenith CMS` |
| `APP_ENV` | Ortam | `local` |
| `APP_DEBUG` | Hata detayları | `true` |
| `APP_URL` | Temel URL | `http://localhost/Zenith` |
| `DB_HOST` | DB sunucusu | `localhost` |
| `DB_NAME` | DB adı | `zenith_db` |
| `DB_USER` | DB kullanıcısı | `root` |
| `DB_PASS` | DB şifresi | — |
| `DB_CHARSET` | Karakter seti | `utf8mb4` |
| `TELEGRAM_BOT_TOKEN` | Bot token | — |
| `TELEGRAM_CHAT_ID` | Chat ID | — |

<br/>

---

<div align="center">

<br/>

<sub>Aydin Sahin tarafından geliştirilmektedir.</sub>

<br/><br/>

</div>
