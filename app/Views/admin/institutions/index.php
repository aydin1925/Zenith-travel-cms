<?php
/** @var array $institutions */

// Kurum tipine gore rozet rengi. Yeni tip eklersen buraya ekle.
$typeBadgeColor = [
    'Okul'    => 'badge-blue',
    'Sirket'  => 'badge-green',
    'Acente'  => 'badge-purple',
    'Diger'   => 'badge-gray',
];

// Logo URL'ini urett (upload'lanmis dosya varsa full URL, yoksa avatar fallback)
function ins_logo(array $inst): string {
    if (!empty($inst['logo_url'])) {
        return e(\App\Core\FileUploader::url($inst['logo_url']));
    }
    $name = urlencode($inst['institution_name'] ?? 'Kurum');
    return "https://ui-avatars.com/api/?name={$name}&background=e0e7ff&color=4f46e5";
}
?>
<header class="top-header">
    <div class="header-title">
        <h1>Kurum (Musteri) Yonetimi</h1>
        <p>Sistemdeki tum B2B partnerlerinizi ve calistiginiz kurumlari detaylica yonetin.</p>
    </div>
    <div class="header-action">
        <button id="openModalBtn" class="btn-primary">
            <i class="fas fa-plus"></i> Yeni Kurum Ekle
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
                <th>Kurum Bilgisi</th>
                <th>Tip</th>
                <th>Yetkili & Iletisim</th>
                <th>Vergi Bilgileri</th>
                <th>Durum</th>
                <th>Islemler</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($institutions)): ?>
            <tr>
                <td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">
                    <i class="fas fa-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                    Henuz kayitli bir kurum yok. Sag ustten yenisini ekleyebilirsin.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($institutions as $inst): ?>
                <?php $badgeClass = $typeBadgeColor[$inst['type']] ?? 'badge-gray'; ?>
                <tr>
                    <td class="cell-title" style="display:flex; align-items:center; gap:12px;">
                        <img src="<?= ins_logo($inst) ?>"
                             alt="Logo"
                             style="width:44px; height:44px; border-radius:10px; object-fit:cover; border:1px solid #e2e8f0; background:#f8fafc;">
                        <div><?= e($inst['institution_name']) ?></div>
                    </td>
                    <td>
                        <span class="badge <?= $badgeClass ?>"><?= e($inst['type']) ?></span>
                    </td>
                    <td>
                        <div style="font-weight:700; color:#0f172a; font-size:14px;">
                            <?= e($inst['contact_person']) ?>
                        </div>
                        <?php if (!empty($inst['phone'])): ?>
                            <div class="cell-subtitle"><i class="fas fa-phone"></i> <?= e($inst['phone']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($inst['email'])): ?>
                            <div class="cell-subtitle" style="font-size:12px; margin-top:2px;">
                                <i class="fas fa-envelope"></i> <?= e($inst['email']) ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($inst['tax_office']) || !empty($inst['tax_number'])): ?>
                            <div style="font-size:13px; color:#475569;">Daire: <b><?= e($inst['tax_office'] ?: '-') ?></b></div>
                            <div style="font-size:13px; color:#475569;">No: <b><?= e($inst['tax_number'] ?: '-') ?></b></div>
                        <?php else: ?>
                            <span style="color:#cbd5e1;">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ((int) $inst['status'] === 1): ?>
                            <span class="badge" style="background-color:#dcfce7; color:#16a34a;">Aktif</span>
                        <?php else: ?>
                            <span class="badge" style="background-color:#fee2e2; color:#dc2626;">Pasif</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions-cell">
                        <button type="button"
                                class="btn-action btn-edit open-edit-modal"
                                data-id="<?= (int) $inst['id'] ?>"
                                data-name="<?= e($inst['institution_name']) ?>"
                                data-type="<?= e($inst['type']) ?>"
                                data-logo="<?= e($inst['logo_url'] ? \App\Core\FileUploader::url($inst['logo_url']) : '') ?>"
                                data-contact="<?= e($inst['contact_person']) ?>"
                                data-phone="<?= e($inst['phone']) ?>"
                                data-email="<?= e($inst['email'] ?? '') ?>"
                                data-taxoffice="<?= e($inst['tax_office'] ?? '') ?>"
                                data-taxnumber="<?= e($inst['tax_number'] ?? '') ?>"
                                data-address="<?= e($inst['address'] ?? '') ?>"
                                data-status="<?= (int) $inst['status'] ?>">
                            <i class="fas fa-pen"></i>
                        </button>

                        <a href="<?= url('/admin/institutions/' . (int) $inst['id'] . '/delete') ?>"
                           class="btn-action btn-delete delete-alert-btn">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- YENI KURUM EKLE MODALI -->
<div id="addServiceModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2 class="modal-title">Yeni Kurum Ekle</h2>

        <form action="<?= url('/admin/institutions') ?>" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group" style="flex:2;">
                    <label>Kurum / Sirket Adi <span style="color:red;">*</span></label>
                    <input type="text" name="institution_name" class="form-control" required placeholder="Orn: Cumhuriyet Ilkokulu">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Kurum Tipi <span style="color:red;">*</span></label>
                    <select name="institution_type" class="form-control" required>
                        <option value="">Seciniz...</option>
                        <option value="Okul">Okul</option>
                        <option value="Sirket">Sirket</option>
                        <option value="Acente">Acente</option>
                        <option value="Diger">Diger</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Logo (Opsiyonel) <span class="hint">JPG · PNG · WEBP · GIF · max 2 MB</span></label>
                <input type="file" name="logo_file" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif"
                       style="padding:8px; cursor:pointer;">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Yetkili Kisi <span style="color:red;">*</span></label>
                    <input type="text" name="contact_person" class="form-control" required placeholder="Orn: Ahmet Yilmaz">
                </div>
                <div class="form-group">
                    <label>Telefon Numarasi <span style="color:red;">*</span></label>
                    <input type="text" name="phone" class="form-control" required placeholder="Orn: 0555 123 4567">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex:2;">
                    <label>E-posta Adresi</label>
                    <input type="email" name="email" class="form-control" placeholder="Orn: info@kurum.com">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Durum</label>
                    <select name="status" class="form-control" required>
                        <option value="1" selected>Aktif</option>
                        <option value="0">Pasif</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Vergi Dairesi</label>
                    <input type="text" name="tax_office" class="form-control" placeholder="Orn: Ilyasbey V.D.">
                </div>
                <div class="form-group">
                    <label>Vergi Numarasi</label>
                    <input type="text" name="tax_number" class="form-control" placeholder="Orn: 1234567890">
                </div>
            </div>

            <div class="form-group">
                <label>Acik Adres</label>
                <textarea name="address" class="form-control" rows="2" style="resize:none;" placeholder="Kurumun acik adresi..."></textarea>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-check"></i> Kurumu Kaydet</button>
        </form>
    </div>
</div>

<!-- DUZENLE MODALI -->
<div id="editServiceModal" class="modal">
    <div class="modal-content">
        <span class="close-edit-btn">&times;</span>
        <h2 class="modal-title">Kurumu Duzenle</h2>

        <!-- action attribute'u JS ile doldurulacak (id degistigi icin) -->
        <form id="editInstForm" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group" style="flex:2;">
                    <label>Kurum / Sirket Adi <span style="color:red;">*</span></label>
                    <input type="text" name="institution_name" id="edit_inst_name" class="form-control" required>
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Kurum Tipi <span style="color:red;">*</span></label>
                    <select name="institution_type" id="edit_inst_type" class="form-control" required>
                        <option value="">Seciniz...</option>
                        <option value="Okul">Okul</option>
                        <option value="Sirket">Sirket</option>
                        <option value="Acente">Acente</option>
                        <option value="Diger">Diger</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Logo <span class="hint">JPG · PNG · WEBP · GIF · max 2 MB</span></label>
                <div id="edit_inst_logo_preview" style="display:none; margin-bottom:10px; padding:12px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; display:flex; align-items:center; gap:12px;">
                    <img id="edit_inst_logo_img" src="" alt="Mevcut logo" style="width:44px; height:44px; border-radius:8px; object-fit:cover; background:#fff; border:1px solid #e2e8f0; padding:2px;">
                    <div style="flex:1; font-size:12.5px; color:#64748b;">
                        <div style="font-weight:600; color:#0f172a; margin-bottom:2px;">Mevcut logo</div>
                        <label style="display:inline-flex; align-items:center; gap:6px; cursor:pointer; color:#dc2626;">
                            <input type="checkbox" name="remove_logo" value="1" style="accent-color:#dc2626;">
                            <span>Kaldir (kaydettiginizde silinir)</span>
                        </label>
                    </div>
                </div>
                <input type="file" name="logo_file" id="edit_inst_logo_file" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif"
                       style="padding:8px; cursor:pointer;">
                <div id="edit_inst_logo_hint" style="margin-top:6px; font-size:11.5px; color:#94a3b8;">
                    Yeni bir dosya sec — mevcut logonun uzerine yazilir.
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Yetkili Kisi <span style="color:red;">*</span></label>
                    <input type="text" name="contact_person" id="edit_inst_contact" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Telefon Numarasi <span style="color:red;">*</span></label>
                    <input type="text" name="phone" id="edit_inst_phone" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex:2;">
                    <label>E-posta Adresi</label>
                    <input type="email" name="email" id="edit_inst_email" class="form-control">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Durum</label>
                    <select name="status" id="edit_inst_status" class="form-control" required>
                        <option value="1">Aktif</option>
                        <option value="0">Pasif</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Vergi Dairesi</label>
                    <input type="text" name="tax_office" id="edit_inst_tax_office" class="form-control">
                </div>
                <div class="form-group">
                    <label>Vergi Numarasi</label>
                    <input type="text" name="tax_number" id="edit_inst_tax_number" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label>Acik Adres</label>
                <textarea name="address" id="edit_inst_address" class="form-control" rows="2" style="resize:none;"></textarea>
            </div>

            <button type="submit" class="btn-submit btn-submit-blue">
                <i class="fas fa-sync-alt"></i> Degisiklikleri Kaydet
            </button>
        </form>
    </div>
</div>

<script>
    const instEditButtons = document.querySelectorAll(".open-edit-modal");
    const instEditModal   = document.getElementById("editServiceModal");
    const instEditForm    = document.getElementById("editInstForm");
    const updateUrlBase   = "<?= url('/admin/institutions') ?>";

    instEditButtons.forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");

            // Form action'ini o kurumun update URL'ine ayarla
            instEditForm.action = `${updateUrlBase}/${id}/update`;

            document.getElementById("edit_inst_name").value       = this.getAttribute("data-name")       || '';
            document.getElementById("edit_inst_type").value       = this.getAttribute("data-type")       || '';

            // Logo preview: mevcut logo varsa göster + kaldır kutucugu görünsün
            const logoUrl = this.getAttribute("data-logo") || '';
            const preview = document.getElementById("edit_inst_logo_preview");
            const img     = document.getElementById("edit_inst_logo_img");
            const removeCb = preview.querySelector('input[name="remove_logo"]');
            if (removeCb) removeCb.checked = false;
            document.getElementById("edit_inst_logo_file").value = '';
            if (logoUrl) {
                img.src = logoUrl;
                preview.style.display = 'flex';
            } else {
                preview.style.display = 'none';
            }

            document.getElementById("edit_inst_contact").value    = this.getAttribute("data-contact")    || '';
            document.getElementById("edit_inst_phone").value      = this.getAttribute("data-phone")      || '';
            document.getElementById("edit_inst_email").value      = this.getAttribute("data-email")      || '';
            document.getElementById("edit_inst_tax_office").value = this.getAttribute("data-taxoffice") || '';
            document.getElementById("edit_inst_tax_number").value = this.getAttribute("data-taxnumber") || '';
            document.getElementById("edit_inst_address").value    = this.getAttribute("data-address")   || '';
            document.getElementById("edit_inst_status").value     = this.getAttribute("data-status")    || '1';

            instEditModal.style.display = "block";
        });
    });
</script>
