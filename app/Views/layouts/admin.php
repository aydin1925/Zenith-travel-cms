<?php
/**
 * Admin layout: sidebar + head + main slot.
 * Controller'dan gelen $content buraya basilir.
 *
 * Beklenen degiskenler:
 *   $pageTitle   - <title>
 *   $activePage  - hangi menu ogesinin aktif olacagi (dashboard|institutions|vehicles|services|settings)
 *   $content     - render edilecek sayfa icerigi
 */
$activePage = $activePage ?? '';
$pageTitle  = $pageTitle  ?? 'Zenith';

// Sidebar'daki "Gelen Mesajlar" badge'i icin okunmamis sayisi
try {
    $__unreadMsg = \App\Models\Message::unreadCount();
} catch (\Throwable $e) {
    $__unreadMsg = 0;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('css/admin_dashboard.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="admin-layout">

        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-plane-departure"></i>
                <h2>Zenith</h2>
            </div>
            <ul class="sidebar-menu">
                <li class="<?= $activePage === 'dashboard' ? 'active' : '' ?>">
                    <a href="<?= url('/admin/dashboard') ?>"><i class="fas fa-home"></i> Gosterge Paneli</a>
                </li>
                <li class="<?= $activePage === 'institutions' ? 'active' : '' ?>">
                    <a href="<?= url('/admin/institutions') ?>"><i class="fas fa-building"></i> Kurum Yonetimi</a>
                </li>
                <li class="<?= $activePage === 'vehicles' ? 'active' : '' ?>">
                    <a href="<?= url('/admin/vehicles') ?>"><i class="fas fa-car"></i> Arac Yonetimi</a>
                </li>
                <li class="<?= $activePage === 'services' ? 'active' : '' ?>">
                    <a href="<?= url('/admin/services') ?>"><i class="fas fa-briefcase"></i> Servis Yonetimi</a>
                </li>
                <li class="<?= $activePage === 'messages' ? 'active' : '' ?>">
                    <a href="<?= url('/admin/messages') ?>">
                        <i class="fas fa-envelope"></i> Gelen Mesajlar
                        <?php if ($__unreadMsg > 0): ?>
                            <span class="sidebar-badge"><?= (int) $__unreadMsg ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="<?= $activePage === 'settings' ? 'active' : '' ?>">
                    <a href="<?= url('/admin/settings') ?>"><i class="fas fa-cog"></i> Sistem Ayarlari</a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="<?= url('/logout') ?>" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Cikis Yap</a>
            </div>
        </aside>

        <main class="main-content">
            <?php
                $__username = $_SESSION['username'] ?? 'Admin';
                $__initial  = strtoupper(mb_substr($__username, 0, 1));
            ?>
            <div class="top-bar">
                <div class="crumb"><i class="fas fa-home"></i> <span>Panel</span></div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <a href="<?= url('/') ?>" target="_blank" class="crumb" style="text-decoration:none;">
                        <i class="fas fa-external-link-alt"></i> <span>Siteyi görüntüle</span>
                    </a>
                    <div class="user-profile" title="<?= e($__username) ?>">
                        <span class="user-name"><?= e($__username) ?></span>
                        <div class="avatar"><?= e($__initial) ?></div>
                    </div>
                </div>
            </div>
            <?= $content ?>
        </main>
    </div>

    <script src="<?= asset('js/admin.js') ?>"></script>
</body>
</html>
