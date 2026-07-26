// ==========================================================================
// Zenith Admin — ortak UI davranislari
// - Ekle modal ac/kapat  (button #openModalBtn, modal .modal, kapatma .close-btn)
// - Edit modal kapat     (.close-edit-btn)
// - Modal disina tiklayinca kapat
// - Silme butonlari icin SweetAlert2 onayi (.delete-alert-btn)
//
// NOT: Edit modal'i acan ve icini dolduran kod her sayfanin kendi <script>'inde
//      (institutions/index.php, services/index.php gibi) — cunku her tablonun
//      farkli alanlari var.
// ==========================================================================

(function () {
    // ---- Ekle modal ----
    const addBtn   = document.getElementById("openModalBtn");
    const addModal = document.getElementById("addServiceModal"); // legacy id — vehicles/services/institutions hepsi ayni id kullaniyor
    const addClose = document.querySelector(".close-btn");

    if (addBtn && addModal) {
        addBtn.addEventListener("click", () => { addModal.style.display = "block"; });
    }
    if (addClose && addModal) {
        addClose.addEventListener("click", () => { addModal.style.display = "none"; });
    }

    // ---- Edit modal kapat (icini doldurma sayfanin script'inde) ----
    const editModal = document.getElementById("editServiceModal");
    const editClose = document.querySelector(".close-edit-btn");
    if (editClose && editModal) {
        editClose.addEventListener("click", () => { editModal.style.display = "none"; });
    }

    // ---- Modal disina tiklayinca kapat ----
    window.addEventListener("click", (event) => {
        if (addModal  && event.target === addModal)  addModal.style.display  = "none";
        if (editModal && event.target === editModal) editModal.style.display = "none";
    });

    // ---- Silme onayi (SweetAlert2) ----
    const deleteButtons = document.querySelectorAll(".delete-alert-btn");
    deleteButtons.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const url = btn.getAttribute("href");

            // data-confirm-text ile ozel mesaj verilebilir; yoksa varsayilan
            const text = btn.getAttribute("data-confirm-text")
                      || "Bu kaydi sildiginde geri alamazsin!";

            Swal.fire({
                title: "Silmek istediginden emin misin?",
                text: text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ef4444",
                cancelButtonColor: "#64748b",
                confirmButtonText: "Evet, sil",
                cancelButtonText: "Iptal"
            }).then((result) => {
                if (result.isConfirmed) window.location.href = url;
            });
        });
    });
})();
