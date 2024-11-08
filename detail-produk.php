<?php
session_start();
include 'koneksi/db.php';

if (isset($_SESSION['user_name'])) {
    $namaPengguna = $_SESSION['user_name'];
}

$idKendaraan = isset($_GET['id_kendaraan']) ? (int)$_GET['id_kendaraan'] : 0;

$productDetails = [];
if ($idKendaraan > 0) {
    $sql = "SELECT * FROM kendaraan WHERE id_kendaraan = $idKendaraan";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $productDetails = mysqli_fetch_assoc($result);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="assets/styles/main.css">
    <link rel="stylesheet" href="assets/styles/detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'assets/components/navbar.php' ?>

    <section class="product-detail">
        <div class="product-image">
            <img src="assets/uploads/<?= htmlspecialchars($productDetails['foto'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($productDetails['nama_kendaraan'] ?? 'Detail Produk') ?>">
        </div>
        <div class="product-info">
            <h2 id="productName"><?= htmlspecialchars($productDetails['nama_kendaraan'] ?? 'Nama Kendaraan') ?></h2>
            <p id="productPrice">Rp<?= number_format($productDetails['harga_sewa'] ?? 0, 0, ',', '.') ?>/hari</p>
            <p>Unit tersedia: <span id="productStock"><?= htmlspecialchars($productDetails['stok_kendaraan'] ?? 0) ?></span> unit</p>

            <form action="pembayaran.php" method="post">
                <div class="rental-duration">
                    <label for="rental-days">Lama Sewa (hari):</label>
                    <input type="number" id="rental-days" name="rental_days" min="1" value="1">
                </div>
                <input type="hidden" name="id_kendaraan" value="<?php echo $idKendaraan; ?>">
                <div class="booking-section">
                    <button id="back-btn" class="back-btn" type="button"a onclick="history.back()">Kembali</button>
                    <button type="submit" class="btn" <?= ($productDetails['stok_kendaraan'] ?? 0) <= 0 ? 'disabled' : '' ?>>
                        <?= ($productDetails['stok_kendaraan'] ?? 0) <= 0 ? 'Tidak Tersedia' : 'Pesan Sekarang' ?>
                    </button>
                </div>
            </form>

        </div>  
    </section>

    <?php include 'assets/components/footer.php' ?>

    <script src="assets/js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hamburger = document.getElementById('hamburger');
            const sidebar = document.getElementById('sidebar');
            const closeBtn = document.getElementById('close-btn');

            // Buka Sidebar saat hamburger diklik
            hamburger.addEventListener('click', function () {
                sidebar.classList.add('active');
            });

            // Tutup Sidebar saat close button diklik
            closeBtn.addEventListener('click', function () {
                sidebar.classList.remove('active');
            });

            // Tutup Sidebar saat mengklik di luar sidebar
            window.addEventListener('click', function (e) {
                if (e.target === sidebar) {
                    sidebar.classList.remove('active');
                }
            });

            // Tutup Sidebar saat salah satu link di sidebar diklik
            const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
            sidebarLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    sidebar.classList.remove('active');
                });
            });
        });
    </script>

</body>
</html>
