<?php
/** @var array $messages */
/** @var array $counts */
/** @var string $filter */

$sourceMap = [
    'contact' => ['Iletisim',   '#e0e7ff', '#4338ca'],
    'quote'   => ['Teklif',     '#ffedd5', '#c2410c'],
];
?>
<header class="top-header">
    <div class="header-title">
        <h1>Gelen Mesajlar</h1>
        <p>Iletisim formu ve teklif talebi sayfalarindan gelen mesajlar burada listelenir.</p>
    </div>
</header>

<?php if ($msg = flash('success')): ?>
    <div class="alert alert-success"><?= e($msg) ?></div>
<?php endif; ?>
<?php if ($msg = flash('error')): ?>
    <div class="alert alert-danger"><?= e($msg) ?></div>
<?php endif; ?>

<!-- Filtre chip'leri -->
<div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px;">
    <?php
    $filters = [
        'all'     => ['Tümü',      (int) $counts['total']],
        'unread'  => ['Okunmamış', (int) $counts['unread']],
        'contact' => ['İletişim',  (int) $counts['contact']],
        'quote'   => ['Teklif',    (int) $counts['quote']],
    ];
    foreach ($filters as $key => [$label, $cnt]):
        $active = ($filter === $key);
    ?>
    <a href="<?= url('/admin/messages' . ($key === 'all' ? '' : '?filter=' . $key)) ?>"
       style="padding:8px 16px; border-radius:999px;
              background:<?= $active ? 'var(--metin-koyu)' : '#fff' ?>;
              color:<?= $active ? '#fff' : 'var(--metin-gri)' ?>;
              border:1px solid <?= $active ? 'var(--metin-koyu)' : 'var(--border-color)' ?>;
              font-size:13.5px; font-weight:500; text-decoration:none;
              display:inline-flex; align-items:center; gap:8px;
              transition:all .18s;">
        <?= e($label) ?>
        <span style="font-family:monospace; font-size:11px;
                     background:<?= $active ? 'rgba(255,255,255,.15)' : 'var(--arka-plan)' ?>;
                     color:<?= $active ? '#fff' : 'var(--metin-gri)' ?>;
                     padding:2px 8px; border-radius:999px;">
            <?= $cnt ?>
        </span>
    </a>
    <?php endforeach; ?>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Durum</th>
                <th>Kaynak</th>
                <th>Ad & İletişim</th>
                <th>Konu</th>
                <th>Tarih</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($messages)): ?>
            <tr>
                <td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">
                    <i class="fas fa-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                    <?= $filter === 'all' ? 'Henüz mesaj yok.' : 'Bu filtrede mesaj yok.' ?>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($messages as $m):
                [$srcLabel, $srcBg, $srcColor] = $sourceMap[$m['source']] ?? ['Diger', '#f1f5f9', '#475569'];
                $isUnread = ((int) $m['is_read'] === 0);
            ?>
            <tr style="<?= $isUnread ? 'background: #fef9e7;' : '' ?>">
                <td>
                    <?php if ($isUnread): ?>
                        <span style="display:inline-flex; align-items:center; gap:6px; color:#d97706; font-weight:600; font-size:12px;">
                            <span style="width:8px; height:8px; border-radius:50%; background:#f59e0b; box-shadow:0 0 6px rgba(245,158,11,.6);"></span>
                            Yeni
                        </span>
                    <?php else: ?>
                        <span style="color:#94a3b8; font-size:12px;">Okundu</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge" style="background-color:<?= $srcBg ?>; color:<?= $srcColor ?>;">
                        <?= e($srcLabel) ?>
                    </span>
                </td>
                <td>
                    <div class="cell-title"><?= e($m['name']) ?></div>
                    <div class="cell-subtitle"><i class="fas fa-phone"></i> <?= e($m['phone']) ?></div>
                    <?php if (!empty($m['email'])): ?>
                    <div class="cell-subtitle" style="font-size:12px; margin-top:2px;">
                        <i class="fas fa-envelope"></i> <?= e($m['email']) ?>
                    </div>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="color:#334155; font-size:14px; max-width:280px;">
                        <?= e($m['subject'] ?: '(Konu belirtilmemiş)') ?>
                    </div>
                    <?php if (!empty($m['company'])): ?>
                    <div style="color:#94a3b8; font-size:12px; margin-top:2px;">
                        <?= e($m['company']) ?>
                    </div>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="font-size:13px; color:#475569;">
                        <?= e(date('d.m.Y', strtotime($m['created_at']))) ?>
                    </div>
                    <div style="font-size:11.5px; color:#94a3b8; font-family:monospace;">
                        <?= e(date('H:i', strtotime($m['created_at']))) ?>
                    </div>
                </td>
                <td class="actions-cell">
                    <a href="<?= url('/admin/messages/' . (int) $m['id']) ?>"
                       class="btn-action btn-edit" title="Detay">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="<?= url('/admin/messages/' . (int) $m['id'] . '/toggle-read') ?>"
                       class="btn-action" title="<?= $isUnread ? 'Okundu isaretle' : 'Okunmadi isaretle' ?>">
                        <i class="fas <?= $isUnread ? 'fa-check' : 'fa-envelope-open' ?>"></i>
                    </a>
                    <a href="<?= url('/admin/messages/' . (int) $m['id'] . '/delete') ?>"
                       class="btn-action btn-delete delete-alert-btn"
                       data-confirm-text="<?= e($m['name']) ?>'in mesajini silmek uzeresin.">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
