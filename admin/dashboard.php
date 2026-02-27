<?php

session_start();

// veritabanını çağırıyorum
require_once '../includes/Database.php';

// 2. Tarayıcının sayfayı hafızasına (cache) almasını KESİN OLARAK engelliyoruz
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// oturum açılmış mı diye kontrol ediyorum
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// nesneleri oluşturuyorum
$database = new Database();
$db = $database->connect();


// sorgu metinlerini yazıyorum
$insQuery = $db->prepare("SELECT COUNT(*) FROM institutions");
$vehQuery = $db->prepare("SELECT COUNT(*) FROM vehicles"); 
$srvsQuery = $db->prepare("SELECT COUNT(*) FROM services"); 

// sorguları çalıştır
$insQuery->execute();
$vehQuery->execute();
$srvsQuery->execute();

// sorgu sonucunu al
$insCount = $insQuery->fetchColumn();
$vehicleCount = $vehQuery->fetchColumn();
$srvsCount = $srvsQuery->fetchColumn();

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenith Yönetim Paneli</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-plane-departure"></i>
                <h2>Zenith</h2>
            </div>
            <ul class="sidebar-menu">
                <li class="active"><a href="#"><i class="fas fa-home"></i> Gösterge Paneli</a></li>
                <li><a href="#"><i class="fas fa-building"></i> Kurum Yönetimi</a></li>
                <li><a href="#"><i class="fas fa-car"></i> Araç Yönetimi</a></li>
                <li><a href="./services.php"><i class="fas fa-map-marked-alt"></i> Servisler </a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Sistem Ayarları</a></li>
            </ul>
            <div class="sidebar-footer">
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="header-title">
                    <h1>Gösterge Paneli</h1>
                    <p>Sisteme hoş geldin, işte Zenith'in genel durumu.</p>
                </div>
                <div class="user-profile">
                    <div class="avatar"><i class="fas fa-user"></i></div>
                </div>
            </header>

            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-icon"><i class="fas fa-bus"></i></div>
                    <div class="card-info">
                        <h3>Aktif Araçlar</h3>
                        <span><?php echo $vehicleCount ?></span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="fas fa-building"></i></div>
                    <div class="card-info">
                        <h3>Çalışılan Kurumlar</h3>
                        <span><?php echo $insCount ?></span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="fas fa-briefcase"></i></div>
                    <div class="card-info">
                        <h3>Aktif Servisler</h3>
                        <span><?php echo $srvsCount ?></span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>