<?php
/** @var array $services */
/** @var array $institutionsList */
/** @var array $vehiclesList */
?>
<header class="top-header">
    <div class="header-title">
        <h1>Servis (Hizmet) Yonetimi</h1>
        <p>Sistemdeki tum servisleri buradan gorebilir, duzenleyebilir veya silebilirsin.</p>
    </div>
    <div class="header-action">
        <button id="openModalBtn" class="btn-primary">
            <i class="fas fa-plus"></i> Yeni Servis Ekle
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
                <th>Servis Adi</th>
                <th>Tipi</th>
                <th>Kurum & Arac Bilgisi</th>
                <th>Fiyat</th>
                <th>Aciklama</th>
                <th>Islemler</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($services)): ?>
            <tr>
                <td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">
                    Henuz servis kaydi yok.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td class="cell-title"><?= e($service['service_title']) ?></td>
                    <td><span class="badge badge-blue"><?= e($service['service_type']) ?></span></td>
                    <td>
                        <div class="cell-title"><?= e($service['institution_name']) ?></div>
                        <div class="cell-subtitle"><i class="fas fa-car"></i> <?= e($service['vehicle_plate']) ?></div>
                    </td>
                    <td>
                        <span class="price-tag">
                            <?= number_format((float) $service['price'], 2, ',', '.') ?>
                            <span class="currency">TL</span>
                        </span>
                    </td>
                    <td class="cell-desc" title="<?= e($service['description']) ?>">
                        <?= e($service['description']) ?>
                    </td>
                    <td class="actions-cell">
                        <button type="button" class="btn-action btn-edit open-edit-modal"
                                data-id="<?= (int) $service['id'] ?>"
                                data-title="<?= e($service['service_title']) ?>"
                                data-type="<?= e($service['service_type']) ?>"
                                data-inst="<?= (int) $service['institution_id'] ?>"
                                data-veh="<?= (int) $service['vehicle_id'] ?>"
                                data-price="<?= e((string) $service['price']) ?>"
                                data-desc="<?= e($service['description']) ?>">
                            <i class="fas fa-pen"></i>
                        </button>

                        <a href="<?= url('/admin/services/' . (int) $service['id'] . '/delete') ?>"
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

<!-- YENI SERVIS EKLE MODAL -->
<div id="addServiceModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2 class="modal-title">Yeni Servis Ekle</h2>

        <form action="<?= url('/admin/services') ?>" method="POST">
            <div class="form-group">
                <label>Servis Adi</label>
                <input type="text" name="service_title" class="form-control" required placeholder="Orn: VIP Havaalani Transferi">
            </div>
            <div class="form-group">
                <label>Servis Tipi</label>
                <input type="text" name="service_type" class="form-control" required placeholder="Orn: Transfer">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kurum Secin</label>
                    <select name="institution_id" class="form-control" required>
                        <option value="">Seciniz...</option>
                        <?php foreach ($institutionsList as $institution): ?>
                            <option value="<?= (int) $institution['id'] ?>"><?= e($institution['institution_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Arac Plakasi</label>
                    <select name="vehicle_id" class="form-control" required>
                        <option value="">Seciniz...</option>
                        <?php foreach ($vehiclesList as $vehicle): ?>
                            <option value="<?= (int) $vehicle['id'] ?>"><?= e($vehicle['plate_number']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Fiyat (TL)</label>
                <input type="number" step="1" min="0" name="price" class="form-control" required placeholder="Orn: 1500">
            </div>
            <div class="form-group">
                <label>Aciklama</label>
                <textarea name="description" class="form-control" rows="3" style="resize:none;" placeholder="Servis detaylarini buraya yazin..."></textarea>
            </div>
            <button type="submit" class="btn-submit"><i class="fas fa-check"></i> Servisi Kaydet</button>
        </form>
    </div>
</div>

<!-- DUZENLE MODAL -->
<div id="editServiceModal" class="modal">
    <div class="modal-content">
        <span class="close-edit-btn">&times;</span>
        <h2 class="modal-title">Servisi Duzenle</h2>

        <form id="editServiceForm" method="POST">
            <div class="form-group">
                <label>Servis Adi</label>
                <input type="text" name="service_title" id="edit_service_title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Servis Tipi</label>
                <input type="text" name="service_type" id="edit_service_type" class="form-control" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Calisilan Kurum</label>
                    <select name="institution_id" id="edit_institution_id" class="form-control" required>
                        <option value="">Seciniz...</option>
                        <?php foreach ($institutionsList as $inst): ?>
                            <option value="<?= (int) $inst['id'] ?>"><?= e($inst['institution_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Gorevli Arac</label>
                    <select name="vehicle_id" id="edit_vehicle_id" class="form-control" required>
                        <option value="">Seciniz...</option>
                        <?php foreach ($vehiclesList as $veh): ?>
                            <option value="<?= (int) $veh['id'] ?>"><?= e($veh['plate_number']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Fiyat (TL)</label>
                <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Aciklama</label>
                <textarea name="description" id="edit_description" class="form-control" rows="3" style="resize:none;"></textarea>
            </div>
            <button type="submit" class="btn-submit btn-submit-blue"><i class="fas fa-sync-alt"></i> Degisiklikleri Kaydet</button>
        </form>
    </div>
</div>

<script>
    const srvEditButtons = document.querySelectorAll(".open-edit-modal");
    const srvEditModal   = document.getElementById("editServiceModal");
    const srvEditForm    = document.getElementById("editServiceForm");
    const srvUrlBase     = "<?= url('/admin/services') ?>";

    srvEditButtons.forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            srvEditForm.action = `${srvUrlBase}/${id}/update`;

            document.getElementById("edit_service_title").value  = this.getAttribute("data-title");
            document.getElementById("edit_service_type").value   = this.getAttribute("data-type");
            document.getElementById("edit_institution_id").value = this.getAttribute("data-inst");
            document.getElementById("edit_vehicle_id").value     = this.getAttribute("data-veh");
            document.getElementById("edit_price").value          = this.getAttribute("data-price");
            document.getElementById("edit_description").value    = this.getAttribute("data-desc");

            srvEditModal.style.display = "block";
        });
    });
</script>
