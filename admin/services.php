<?php 

// oturum kontrolü
session_start();


// oturum açılmadıysa login.php'ye geri gönder
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// gereklileri çağırıyorum
require_once '../includes/Database.php';

$database = new Database();
$db = $database->connect();

// CREATE
if(isset($_POST['submit_service'])) {

    // verileri topladım
    $title   = $_POST['service_title'];
    $type    = $_POST['service_type'];
    $inst_id = $_POST['institution_id'];
    $veh_id  = $_POST['vehicle_id'];
    $price   = $_POST['price'];
    $desc    = $_POST['description'];

    // PDO ile İSİMLENDİRİLMİŞ INSERT sorgusu
    $insertQuery = $db->prepare("INSERT INTO services (service_title, service_type, institution_id, vehicle_id, price, description) VALUES (:baslik, :tip, :kurum, :arac, :fiyat, :aciklama)");

    // Verileri eşleştirerek çalıştırıyorum
    $insertQuery->execute([
        ':baslik'   => $title,
        ':tip'      => $type,
        ':kurum'    => $inst_id,
        ':arac'     => $veh_id,
        ':fiyat'    => $price,
        ':aciklama' => $desc
    ]);

    // İşlem bitince sayfayı yenile
    header("Location: services.php");
    exit;
}

// DELETE
if(isset($_GET['del_id'])) {
    $service_id = intval($_GET['del_id']);

    try {
        // Silme sorgusunu hazırlıyorum
        $sql = "DELETE FROM services WHERE id = :service_id";
        $statement = $db->prepare($sql);
        $statement->execute([':service_id' => $service_id]);

        
        header("Location: services.php");
        exit;

    } catch (PDOException $e) {
        die("Silme işlemi sırasında hata oluştu: " . $e->getMessage());
    }
}

// READ
$sql = "SELECT services.*,
        institutions.institution_name AS institution_name,
        vehicles.plate_number AS vehicle_plate
    FROM services
    LEFT JOIN institutions ON services.institution_id = institutions.id
    LEFT JOIN vehicles ON services.vehicle_id = vehicles.id";    
$query = $db->prepare($sql);
$query->execute();
$servicesList = $query->fetchAll(PDO::FETCH_ASSOC);

// Şu anda services tablosunun içindeki bütün veriler $servicesList listesinin içinde

// Açılır liste verileri
$insSql= "SELECT id, institution_name FROM institutions";
$insQuery = $db->prepare($insSql);
$insQuery->execute();
$institutionsList = $insQuery->fetchAll(PDO::FETCH_ASSOC);

$vehSql = "SELECT id, plate_number FROM vehicles";
$vehQuery = $db->prepare($vehSql);
$vehQuery->execute();
$vehiclesList = $vehQuery->fetchAll(PDO::FETCH_ASSOC);

// UPDATE
if(isset($_POST['update_service'])) {

    $id = intval($_POST['service_id']);
    $title = $_POST['service_title'];
    $type = $_POST['service_type'];
    $inst_id = $_POST['institution_id'];
    $veh_id = $_POST['vehicle_id'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    try{
        
        // sorgu metnini hazırlıyorum
        $sql = "UPDATE services SET service_title = :title, service_type = :type, institution_id = :inst_id, vehicle_id = :veh_id, price = :price, description = :desc WHERE id = :id";
        $statement = $db->prepare($sql);
        $statement->execute([
            ':title' => $title,
            ':type' => $type,
            ':inst_id' => $inst_id,
            ':veh_id' => $veh_id,
            ':price' => $price,
            ':desc' => $desc,
            ':id' => $id
        ]);
    
        header("Location: services.php");
        exit;

    }
    catch(PDOException $e) {
        die("Güncelleme sırasında bir hata oluştu: " . $e->getMessage());
    }

}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Zenith | Servis Yönetimi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Tablo için ufak ek CSS */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
        .data-table th, .data-table td { padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .data-table th { background-color: #f8fafc; font-weight: 600; color: #475569; }
        .data-table tr:hover { background-color: #f1f5f9; }
        .btn-action { padding: 8px 12px; border-radius: 6px; text-decoration: none; color: white; font-size: 14px; margin-right: 5px; }
        .btn-edit { background-color: #3b82f6; }
        .btn-delete { background-color: #ef4444; }
    </style>
</head>
<body>
    <div class="admin-layout">
        
        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-plane-departure"></i>
                <h2>Zenith</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Gösterge Paneli</a></li>                
                <li><a href="institutions.php"><i class="fas fa-building"></i> Kurum Yönetimi</a></li>
                <li><a href="vehicles.php"><i class="fas fa-car"></i> Araç Yönetimi</a></li>
                <li class="active"><a href="services.php"><i class="fas fa-briefcase"></i> Servis Yönetimi</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Sistem Ayarları</a></li>
            </ul>
            <div class="sidebar-footer">
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <div class="header-title">
                    <h1 style="font-size: 24px; color: #0f172a;">Servis (Hizmet) Yönetimi</h1>
                    <p style="color: #64748b; font-size: 14px; margin-top: 5px;">Sistemdeki tüm servisleri buradan görebilir, düzenleyebilir veya silebilirsin.</p>
                </div>
                <div class="header-action">
                    <button id="openModalBtn" style="background-color: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-size: 15px;"><i class="fas fa-plus"></i> Yeni Servis Ekle</button>
                </div>
            </header>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Servis Adı</th>
                        <th>Servis Tipi</th>
                        <th>Çalışılan Kurum</th>
                        <th>Görevli Araç</th>
                        <th>Fiyat / Detay</th>
                        <th>Açıklama</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($servicesList as $service): ?>
                    <tr>
                        <td><?= $service['service_title'] ?></td>
                        <td><?= $service['service_type'] ?></td>
                        <td><?= $service['institution_name'] ?></td>
                        <td><?= $service['vehicle_plate'] ?></td>
                        <td><?= $service['price'] ?></td>
                        <td><?= $service['description'] ?> </td>

                        <td>
                            <button type="button" class="btn-action btn-edit open-edit-modal" 
                                data-id="<?= $service['id'] ?>"
                                data-title="<?= htmlspecialchars($service['service_title']) ?>"
                                data-type="<?= htmlspecialchars($service['service_type']) ?>"
                                data-inst="<?= $service['institution_id'] ?>"
                                data-veh="<?= $service['vehicle_id'] ?>"
                                data-price="<?= $service['price'] ?>"
                                data-desc="<?= htmlspecialchars($service['description']) ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <a href="services.php?del_id=<?= $service['id'] ?>" class="btn-action btn-delete delete-alert-btn">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="addServiceModal" class="modal">
                <div class="modal-content">
                    <span class="close-btn">&times;</span>
                    <h2 style="margin-bottom: 20px; color: #0f172a;">Yeni Servis Ekle</h2>
                    
                    <form action="services.php" method="POST">
                        <div class="form-group">
                            <label>Servis Adı</label>
                            <input type="text" name="service_title" class="form-control" required placeholder="Örn: VIP Havaalanı Transferi">
                        </div>
                        <div class="form-group">
                            <label>Servis Tipi</label>
                            <input type="text" name="service_type" class="form-control" required placeholder="Örn: Transfer">
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <div class="form-group" style="flex: 1;">
                                <label>Kurum Seçin</label>
                                <select name="institution_id" class="form-control" required>
                                    <option value="">Kurum Seçin</option>
                                <?php foreach($institutionsList as $institution): ?>
                                    <option value="<?= $institution['id'] ?>"> <?= $institution['institution_name'] ?> </option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label>Araç Plakası</label>
                                <select name="vehicle_id" class="form-control" required>
                                <option value="">Araç Seçin</option>
                                <?php foreach($vehiclesList as $vehicle): ?>
                                    <option value="<?= $vehicle['id'] ?>"> <?= $vehicle['plate_number'] ?> </option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Fiyat</label>
                            <input type="number" step="1" min="0" name="price" class="form-control" required placeholder="Örn: 1500.00">
                        </div>
                        <div class="form-group">
                            <label>Açıklama</label>
                            <textarea name="description" class="form-control" rows="3" style="resize:none"; placeholder="Servis detaylarını buraya yazın..."></textarea>
                        </div>
                        <button type="submit" name="submit_service" class="btn-submit"><i class="fas fa-save"></i> Servisi Kaydet</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <div id="editServiceModal" class="modal">
        <div class="modal-content">
            <span class="close-edit-btn" style="position: absolute; top: 20px; right: 25px; font-size: 24px; cursor: pointer;">&times;</span>
            <h2 style="margin-bottom: 20px; color: #0f172a;">Servisi Düzenle</h2>
        
            <form action="services.php" method="POST">
                <input type="hidden" name="service_id" id="edit_service_id">

                <div class="form-group">
                    <label>Servis Adı</label>
                    <input type="text" name="service_title" id="edit_service_title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Servis Tipi</label>
                    <input type="text" name="service_type" id="edit_service_type" class="form-control" required>
                </div>
                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Çalışılan Kurum</label>
                        <select name="institution_id" id="edit_institution_id" class="form-control" required>
                            <option value="">-- Kurum Seçin --</option>
                            <?php foreach($institutionsList as $inst): ?>
                                <option value="<?= $inst['id'] ?>"><?= $inst['institution_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Görevli Araç</label>
                        <select name="vehicle_id" id="edit_vehicle_id" class="form-control" required>
                            <option value="">-- Araç Seçin --</option>
                            <?php foreach($vehiclesList as $veh): ?>
                                <option value="<?= $veh['id'] ?>"><?= $veh['plate_number'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Fiyat</label>
                    <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" name="update_service" class="btn-submit" style="background-color: #3b82f6;"><i class="fas fa-sync-alt"></i> Değişiklikleri Kaydet</button>
            </form>
        </div>
    </div>

    <script src="../assets/js/admin.js"></script>
</body>
</html>