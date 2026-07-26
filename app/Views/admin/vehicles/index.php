<?php
/** @var array $vehicles */

// Durum -> rozet ayarlari
$statusMap = [
    'aktif'   => ['label' => 'Aktif',    'bg' => '#dcfce7', 'color' => '#16a34a'],
    'bakimda' => ['label' => 'Bakimda',  'bg' => '#fef3c7', 'color' => '#d97706'],
    'pasif'   => ['label' => 'Pasif',    'bg' => '#fee2e2', 'color' => '#dc2626'],
];

// Tip -> rozet
$typeMap = [
    'sprinter' => ['Sprinter', '#e0e7ff', '#4338ca'],
    'midibus'  => ['Midibüs',  '#ffedd5', '#c2410c'],
    'otobus'   => ['Otobüs',   '#ecfeff', '#0e7490'],
    'vip'      => ['VIP Van',  '#fef3c7', '#a16207'],
];

// Fotograf yoksa varsayilan bir arac ikonu placeholder'i
function veh_photo(array $v): string {
    if (!empty($v['photo_url'])) {
        return e(\App\Core\FileUploader::url($v['photo_url']));
    }
    return 'https://ui-avatars.com/api/?name=' . urlencode($v['plate_number'] ?? 'Arac')
         . '&background=e0e7ff&color=4f46e5&length=2&bold=true';
}
?>
<header class="top-header">
    <div class="header-title">
        <h1>Arac Yonetimi</h1>
        <p>Filodaki tum araclari kayit altina alin; plaka, kapasite ve durum bilgisini yonetin.</p>
    </div>
    <div class="header-action">
        <button id="openModalBtn" class="btn-primary">
            <i class="fas fa-plus"></i> Yeni Arac Ekle
        </button>
    </div>
</header>

<?php if ($msg = flash('success')): ?>
    <div class="alert alert-success"><?= e($msg) ?></div>
<?php endif; ?>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Arac</th>
                <th>Plaka</th>
                <th>Tip</th>
                <th>Kapasite</th>
                <th>Model Yili</th>
                <th>Ozellikler</th>
                <th>Durum</th>
                <th>Islemler</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($vehicles)): ?>
            <tr>
                <td colspan="8" style="text-align:center; padding:40px; color:#94a3b8;">
                    <i class="fas fa-car" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                    Henuz kayitli bir arac yok. Sag ustten yenisini ekleyebilirsin.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($vehicles as $v): ?>
                <?php $s = $statusMap[$v['status']] ?? $statusMap['aktif']; ?>
                <tr>
                    <td class="cell-title" style="display:flex; align-items:center; gap:12px;">
                        <img src="<?= veh_photo($v) ?>"
                             alt="Arac"
                             style="width:52px; height:52px; border-radius:10px; object-fit:cover; border:1px solid #e2e8f0; background:#f8fafc;">
                        <div>
                            <div style="font-weight:700; color:#0f172a;"><?= e($v['brand_model']) ?></div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-blue" style="font-family:monospace; letter-spacing:.5px;">
                            <?= e($v['plate_number']) ?>
                        </span>
                    </td>
                    <td>
                        <?php $t = $typeMap[$v['type'] ?? 'sprinter'] ?? $typeMap['sprinter']; ?>
                        <span class="badge" style="background:<?= $t[1] ?>; color:<?= $t[2] ?>;"><?= e($t[0]) ?></span>
                    </td>
                    <td>
                        <?= !empty($v['capacity']) ? e($v['capacity']) . ' kisi' : '<span style="color:#cbd5e1;">-</span>' ?>
                    </td>
                    <td>
                        <?= !empty($v['model_year']) ? (int) $v['model_year'] : '<span style="color:#cbd5e1;">-</span>' ?>
                    </td>
                    <td class="cell-desc" title="<?= e($v['features']) ?>">
                        <?= !empty($v['features']) ? e($v['features']) : '<span style="color:#cbd5e1;">-</span>' ?>
                    </td>
                    <td>
                        <span class="badge" style="background-color:<?= $s['bg'] ?>; color:<?= $s['color'] ?>;">
                            <?= e($s['label']) ?>
                        </span>
                    </td>
                    <td class="actions-cell">
                        <button type="button"
                                class="btn-action btn-edit open-edit-modal"
                                data-id="<?= (int) $v['id'] ?>"
                                data-brand="<?= e($v['brand_model']) ?>"
                                data-plate="<?= e($v['plate_number']) ?>"
                                data-type="<?= e($v['type'] ?? 'sprinter') ?>"
                                data-capacity="<?= e($v['capacity'] ?? '') ?>"
                                data-year="<?= e((string) ($v['model_year'] ?? '')) ?>"
                                data-features="<?= e($v['features'] ?? '') ?>"
                                data-photo="<?= e($v['photo_url'] ? \App\Core\FileUploader::url($v['photo_url']) : '') ?>"
                                data-status="<?= e($v['status']) ?>">
                            <i class="fas fa-pen"></i>
                        </button>

                        <a href="<?= url('/admin/vehicles/' . (int) $v['id'] . '/delete') ?>"
                           class="btn-action btn-delete delete-alert-btn"
                           data-confirm-text="<?= e($v['plate_number']) ?> plakali araci silmek uzeresin.">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- YENI ARAC MODAL -->
<div id="addServiceModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2 class="modal-title">Yeni Arac Ekle</h2>

        <form action="<?= url('/admin/vehicles') ?>" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group" style="flex:2;">
                    <label>Marka / Model <span style="color:red;">*</span></label>
                    <input type="text" name="brand_model" class="form-control" required placeholder="Orn: Mercedes-Benz Sprinter 316">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Plaka <span style="color:red;">*</span></label>
                    <input type="text" name="plate_number" class="form-control" required placeholder="63 ABC 123"
                           style="text-transform:uppercase; font-family:monospace; letter-spacing:.5px;">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tip <span style="color:red;">*</span></label>
                    <select name="type" class="form-control" required>
                        <option value="sprinter">Sprinter (14–19 kişi)</option>
                        <option value="midibus">Midibüs (26–35 kişi)</option>
                        <option value="otobus">Otobüs (40–46 kişi)</option>
                        <option value="vip">VIP Van (8 kişi)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kapasite (kisi)</label>
                    <input type="number" name="capacity" class="form-control" min="1" max="100" placeholder="Orn: 19">
                </div>
                <div class="form-group">
                    <label>Model Yili</label>
                    <input type="number" name="model_year" class="form-control" min="1990" max="<?= (int) date('Y') + 1 ?>" placeholder="Orn: <?= (int) date('Y') ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex:2;">
                    <label>Fotograf <span class="hint">JPG · PNG · WEBP · GIF · max 2 MB</span></label>
                    <input type="file" name="photo_file" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif"
                           style="padding:8px; cursor:pointer;">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Durum <span style="color:red;">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="aktif" selected>Aktif</option>
                        <option value="bakimda">Bakimda</option>
                        <option value="pasif">Pasif</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Ozellikler</label>
                <textarea name="features" class="form-control" rows="2" style="resize:none;" placeholder="Klima, GPS takipli, kamera kayitli, engelli rampasi..."></textarea>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-check"></i> Araci Kaydet</button>
        </form>
    </div>
</div>

<!-- DUZENLE MODAL -->
<div id="editServiceModal" class="modal">
    <div class="modal-content">
        <span class="close-edit-btn">&times;</span>
        <h2 class="modal-title">Araci Duzenle</h2>

        <form id="editVehicleForm" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group" style="flex:2;">
                    <label>Marka / Model <span style="color:red;">*</span></label>
                    <input type="text" name="brand_model" id="edit_veh_brand" class="form-control" required>
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Plaka <span style="color:red;">*</span></label>
                    <input type="text" name="plate_number" id="edit_veh_plate" class="form-control" required
                           style="text-transform:uppercase; font-family:monospace; letter-spacing:.5px;">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tip <span style="color:red;">*</span></label>
                    <select name="type" id="edit_veh_type" class="form-control" required>
                        <option value="sprinter">Sprinter</option>
                        <option value="midibus">Midibüs</option>
                        <option value="otobus">Otobüs</option>
                        <option value="vip">VIP Van</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kapasite (kisi)</label>
                    <input type="number" name="capacity" id="edit_veh_capacity" class="form-control" min="1" max="100">
                </div>
                <div class="form-group">
                    <label>Model Yili</label>
                    <input type="number" name="model_year" id="edit_veh_year" class="form-control" min="1990" max="<?= (int) date('Y') + 1 ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex:2;">
                    <label>Fotograf <span class="hint">JPG · PNG · WEBP · GIF · max 2 MB</span></label>
                    <div id="edit_veh_photo_preview" style="display:none; margin-bottom:10px; padding:12px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; display:flex; align-items:center; gap:12px;">
                        <img id="edit_veh_photo_img" src="" alt="Mevcut foto" style="width:56px; height:56px; border-radius:8px; object-fit:cover; background:#fff; border:1px solid #e2e8f0;">
                        <div style="flex:1; font-size:12.5px; color:#64748b;">
                            <div style="font-weight:600; color:#0f172a; margin-bottom:2px;">Mevcut fotograf</div>
                            <label style="display:inline-flex; align-items:center; gap:6px; cursor:pointer; color:#dc2626;">
                                <input type="checkbox" name="remove_photo" value="1" style="accent-color:#dc2626;">
                                <span>Kaldir</span>
                            </label>
                        </div>
                    </div>
                    <input type="file" name="photo_file" id="edit_veh_photo_file" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif"
                           style="padding:8px; cursor:pointer;">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Durum <span style="color:red;">*</span></label>
                    <select name="status" id="edit_veh_status" class="form-control" required>
                        <option value="aktif">Aktif</option>
                        <option value="bakimda">Bakimda</option>
                        <option value="pasif">Pasif</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Ozellikler</label>
                <textarea name="features" id="edit_veh_features" class="form-control" rows="2" style="resize:none;"></textarea>
            </div>

            <button type="submit" class="btn-submit btn-submit-blue">
                <i class="fas fa-sync-alt"></i> Degisiklikleri Kaydet
            </button>
        </form>
    </div>
</div>

<script>
    const vehEditButtons = document.querySelectorAll(".open-edit-modal");
    const vehEditModal   = document.getElementById("editServiceModal");
    const vehEditForm    = document.getElementById("editVehicleForm");
    const vehUrlBase     = "<?= url('/admin/vehicles') ?>";

    vehEditButtons.forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            vehEditForm.action = `${vehUrlBase}/${id}/update`;

            document.getElementById("edit_veh_brand").value    = this.getAttribute("data-brand")    || '';
            document.getElementById("edit_veh_plate").value    = this.getAttribute("data-plate")    || '';
            document.getElementById("edit_veh_type").value     = this.getAttribute("data-type")     || 'sprinter';
            document.getElementById("edit_veh_capacity").value = this.getAttribute("data-capacity") || '';
            document.getElementById("edit_veh_year").value     = this.getAttribute("data-year")     || '';
            document.getElementById("edit_veh_features").value = this.getAttribute("data-features") || '';
            document.getElementById("edit_veh_status").value   = this.getAttribute("data-status")   || 'aktif';

            // Foto preview
            const photoUrl = this.getAttribute("data-photo") || '';
            const preview  = document.getElementById("edit_veh_photo_preview");
            const img      = document.getElementById("edit_veh_photo_img");
            const removeCb = preview.querySelector('input[name="remove_photo"]');
            if (removeCb) removeCb.checked = false;
            document.getElementById("edit_veh_photo_file").value = '';
            if (photoUrl) {
                img.src = photoUrl;
                preview.style.display = 'flex';
            } else {
                preview.style.display = 'none';
            }

            vehEditModal.style.display = "block";
        });
    });
</script>
