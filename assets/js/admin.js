// ::::: CREATE POPUP

let modal = document.getElementById("addServiceModal");
let btn = document.getElementById("openModalBtn");
let span = document.getElementsByClassName("close-btn")[0];

// Butona basınca aç
btn.onclick = function() { modal.style.display = "block"; }
// Çarpıya basınca kapat
span.onclick = function() { modal.style.display = "none"; }
// Kutu dışına tıklayınca kapat
window.onclick = function(event) { if (event.target == modal) { modal.style.display = "none"; } }

// ::::: DELETE BUTTON :::::

// Sayfadaki "delete-alert-btn" class'ına sahip tüm butonları bul
const deleteButtons = document.querySelectorAll('.delete-alert-btn');

// Her bir buton için bir tıklama dinleyicisi (event listener) oluştur
deleteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        
        // 1. ÇOK KRİTİK: Butonun varsayılan "linke git" hareketini engelle!
        // Eğer bunu yazmazsak, uyarı çıkmadan sayfa anında silme linkine gider.
        e.preventDefault(); 
        
        // 2. Tıkladığımız butonun gideceği o URL'yi (services.php?del_id=5) bir değişkene al
        const deleteUrl = this.getAttribute('href'); 

        // 3. SweetAlert2 ile o havalı popup'ı çağır
        Swal.fire({
            title: 'Silmek istediğine emin misin?',
            text: "Bu servisi sildiğinde geri alamazsın!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Kırmızı
            cancelButtonColor: '#64748b',  // Gri
            confirmButtonText: 'Evet, Sil!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            // 4. Eğer kullanıcı "Evet, Sil!" butonuna bastıysa (isConfirmed true ise)
            if (result.isConfirmed) {
                // Az önce beklemeye aldığımız o linke sayfayı şimdi yönlendir
                window.location.href = deleteUrl;
            }
        });
        
    });
});

// DÜZENLEME MODALI İŞLEMLERİ
const editModal = document.getElementById("editServiceModal");
const closeEditBtn = document.querySelector(".close-edit-btn");
const editButtons = document.querySelectorAll(".open-edit-modal");

// Her bir düzenle butonuna tıklandığında...
editButtons.forEach(button => {
    button.addEventListener("click", function() {
        // 1. Butonun ceplerindeki (data-...) verileri al
        const id = this.getAttribute("data-id");
        const title = this.getAttribute("data-title");
        const type = this.getAttribute("data-type");
        const inst = this.getAttribute("data-inst");
        const veh = this.getAttribute("data-veh");
        const price = this.getAttribute("data-price");
        const desc = this.getAttribute("data-desc");

        // 2. Bu verileri Edit Modal'ının içindeki inputlara yerleştir
        document.getElementById("edit_service_id").value = id;
        document.getElementById("edit_service_title").value = title;
        document.getElementById("edit_service_type").value = type;
        document.getElementById("edit_institution_id").value = inst;
        document.getElementById("edit_vehicle_id").value = veh;
        document.getElementById("edit_price").value = price;
        document.getElementById("edit_description").value = desc;

        // 3. Modalı görünür yap
        editModal.style.display = "block";
    });
});

// Çarpıya basınca düzenle modalını kapat
if(closeEditBtn) {
    closeEditBtn.onclick = function() { editModal.style.display = "none"; }
}
// Dışarı tıklayınca kapatmayı da eski window.onclick içine ekleyebilirsin veya böyle yazabilirsin:
window.addEventListener("click", function(event) {
    if (event.target == editModal) { editModal.style.display = "none"; }
});