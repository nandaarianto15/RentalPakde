// Fungsi untuk menginisialisasi payment accordion
function initPaymentAccordion() {
    document.querySelectorAll('.option-header').forEach(header => {
        header.addEventListener('click', () => {
            const option = header.parentElement;
            const content = header.nextElementSibling;
            
            // Toggle active class
            option.classList.toggle('active');
            
            // Close other options
            document.querySelectorAll('.option').forEach(otherOption => {
                if (otherOption !== option) {
                    otherOption.classList.remove('active');
                }
            });
        });
    });
}

// Event listener untuk tombol "Lihat Semua"
function initViewAllButtons() {
    document.querySelectorAll('.view-all').forEach(button => {
        button.addEventListener('click', () => {
            alert('Show more vehicles in this category');
        });
    });
}

// Fungsi untuk menampilkan detail produk dan menyimpan data di localStorage
function showProductDetail(name, price, condition, stock, imageUrl) {
    // Menyimpan data ke localStorage
    localStorage.setItem("productName", name);
    localStorage.setItem("productPrice", price);
    localStorage.setItem("productCondition", condition);
    localStorage.setItem("productStock", stock);
    localStorage.setItem("productImage", imageUrl);
    
    // Arahkan ke halaman detail produk
    window.location.href = "detail-produk.html";
}

// Fungsi untuk menginisialisasi detail produk
function initProductDetail() {
    const productName = localStorage.getItem("productName");
    const productPrice = localStorage.getItem("productPrice");
    const productCondition = localStorage.getItem("productCondition");
    const productStock = localStorage.getItem("productStock");
    const productImage = localStorage.getItem("productImage");

    // Cek apakah kita berada di halaman detail produk
    const isDetailPage = document.getElementById("product-name") !== null;

    if (isDetailPage && productName && productPrice && productCondition && productStock && productImage) {
        document.getElementById("product-name").textContent = productName;
        document.getElementById("product-price").textContent = productPrice + "/hari";
        document.getElementById("product-condition").textContent = "Kondisi kendaraan: " + productCondition;
        document.getElementById("product-stock").textContent = "Unit tersedia: " + productStock + " unit";
        document.getElementById("product-image").src = productImage;
    }

    // Set default product image jika ada
    const productImageElement = document.getElementById("productImage");
    if (productImageElement) {
        productImageElement.src = productImage ? productImage : "images/honda-vario.jpg";
    }
}

// Menjalankan semua inisialisasi setelah DOM selesai dimuat
document.addEventListener('DOMContentLoaded', () => {
    initPaymentAccordion();
    initViewAllButtons();
    initProductDetail();
});

// Export fungsi yang mungkin dibutuhkan di file JS lain
export {
    showProductDetail,
    initPaymentAccordion,
    initViewAllButtons,
    initProductDetail
};

document.getElementById('updateProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    
    fetch('update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Redirect atau refresh halaman jika diperlukan
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan! Silakan coba lagi.'
        });
    });
});

// Fungsi JavaScript untuk menangani form login dengan AJAX
function login(event) {
    event.preventDefault();

    // Ambil data form
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Kirim data menggunakan fetch
    fetch("login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            // Jika login berhasil, arahkan ke halaman profil
            window.location.href = "index.php";
        } else {
            // Jika login gagal, tampilkan pesan alert dengan JSON message
            alert(data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}

