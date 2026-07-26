<?php
/** @var int $insCount */
/** @var int $vehicleCount */
/** @var int $srvsCount */
/** @var int $unreadMsgs */
/** @var int $totalMsgs */
/** @var array $recentMsgs */
?>
<header class="top-header">
    <div class="header-title">
        <h1>Gosterge Paneli</h1>
        <p>Sisteme hos geldin, iste Zenith'in genel durumu.</p>
    </div>
</header>

<?php if ($msg = flash('success')): ?>
    <div class="alert alert-success"><?= e($msg) ?></div>
<?php endif; ?>

<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon"><i class="fas fa-bus"></i></div>
        <div class="card-info">
            <h3>Aktif Araclar</h3>
            <span><?= (int) $vehicleCount ?></span>
        </div>
    </div>
    <div class="card">
        <div class="card-icon"><i class="fas fa-building"></i></div>
        <div class="card-info">
            <h3>Calisilan Kurumlar</h3>
            <span><?= (int) $insCount ?></span>
        </div>
    </div>
    <div class="card">
        <div class="card-icon"><i class="fas fa-briefcase"></i></div>
        <div class="card-info">
            <h3>Aktif Servisler</h3>
            <span><?= (int) $srvsCount ?></span>
        </div>
    </div>
    <a href="<?= url('/admin/messages') ?>" class="card" style="text-decoration:none; <?= $unreadMsgs > 0 ? 'border-color: #fed7aa;' : '' ?>">
        <div class="card-icon" style="<?= $unreadMsgs > 0 ? 'background:#ffedd5; color:#c2410c;' : '' ?>">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="card-info">
            <h3>Okunmamis Mesaj</h3>
            <span><?= (int) $unreadMsgs ?><span style="font-size:14px; color:#94a3b8; font-weight:500; margin-left:8px;">/ <?= (int) $totalMsgs ?></span></span>
        </div>
    </a>
</div>

<?php if (!empty($recentMsgs)): ?>
<div style="margin-top:32px; background:#fff; border:1px solid var(--border-color); border-radius:20px; overflow:hidden; box-shadow:var(--shadow-sm);">
    <div style="padding:20px 24px; border-bottom:1px solid var(--border-color); display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h3 style="font-size:15px; font-weight:600; letter-spacing:-0.015em; color:var(--metin-koyu);">Son Gelen Mesajlar</h3>
            <p style="font-size:13px; color:var(--metin-gri); margin-top:2px;">Henuz okunmamis en yeni 5 mesaj</p>
        </div>
        <a href="<?= url('/admin/messages') ?>" style="font-size:13px; color:var(--ana-renk); font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
            Tumunu gor <i class="fas fa-arrow-right" style="font-size:11px;"></i>
        </a>
    </div>
    <table class="data-table" style="border-radius:0;">
        <?php foreach ($recentMsgs as $rm):
            $srcBg = $rm['source'] === 'quote' ? '#ffedd5' : '#e0e7ff';
            $srcColor = $rm['source'] === 'quote' ? '#c2410c' : '#4338ca';
            $srcLabel = $rm['source'] === 'quote' ? 'Teklif' : 'Iletisim';
        ?>
        <tr>
            <td style="width:80px;">
                <span class="badge" style="background-color:<?= $srcBg ?>; color:<?= $srcColor ?>;">
                    <?= e($srcLabel) ?>
                </span>
            </td>
            <td>
                <div class="cell-title"><?= e($rm['name']) ?></div>
                <div class="cell-subtitle"><i class="fas fa-phone"></i> <?= e($rm['phone']) ?></div>
            </td>
            <td>
                <div style="font-size:13.5px; color:#334155;"><?= e($rm['subject'] ?: '(Konu yok)') ?></div>
            </td>
            <td style="text-align:right; width:150px;">
                <div style="font-size:12.5px; color:#94a3b8;">
                    <?= e(date('d.m.Y H:i', strtotime($rm['created_at']))) ?>
                </div>
            </td>
            <td class="actions-cell" style="width:80px;">
                <a href="<?= url('/admin/messages/' . (int) $rm['id']) ?>" class="btn-action btn-edit" title="Detay">
                    <i class="fas fa-eye"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>
