<?php
include 'koneksi/db.php';

session_start();

if (isset($_SESSION['user_name'])) {
    $namaPengguna = $_SESSION['user_name'];
}

$jenis_kendaraan = isset($_GET['jenis_kendaraan']) ? $_GET['jenis_kendaraan'] : '';

$sql = $jenis_kendaraan ? 
    "SELECT * FROM kendaraan WHERE jenis_kendaraan = '$jenis_kendaraan'" : 
    "SELECT * FROM kendaraan";

$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kendaraan - <?php echo htmlspecialchars($jenis_kendaraan ? $jenis_kendaraan : 'Semua Kendaraan'); ?></title>
    <link rel="stylesheet" href="assets/styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'assets/components/navbar.php' ?>

    <section class="daftar-section">
        <h1 class="section-title">Daftar <?php echo htmlspecialchars($jenis_kendaraan ? $jenis_kendaraan : 'Semua Kendaraan'); ?></h1>
        
        <div class="vehicles-list">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <a href="detail-produk.php?id_kendaraan=<?php echo htmlspecialchars($row['id_kendaraan']); ?>" class="vehicle-item" style="text-decoration: none;">
                        <img src="assets/uploads/<?php echo htmlspecialchars($row['foto']); ?>" alt="<?php echo htmlspecialchars($row['nama_kendaraan']); ?>">
                        <h3><?php echo htmlspecialchars($row['nama_kendaraan']); ?></h3>
                        <p>Rp<?php echo number_format($row['harga_sewa'], 0, ',', '.'); ?>/hari</p>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Tidak ada kendaraan yang tersedia.</p>
            <?php endif; ?>
        </div>

        <div class="pagination">
            <a href="#">&lt;</a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">&gt;</a>
        </div>
    </section>

    <?php include 'assets/components/footer.php' ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hamburger = document.getElementById('hamburger');
            const sidebar = document.getElementById('sidebar');
            const closeBtn = document.getElementById('close-btn');

            hamburger.addEventListener('click', function () {
                sidebar.classList.add('active');
            });

            closeBtn.addEventListener('click', function () {
                sidebar.classList.remove('active');
            });

            window.addEventListener('click', function (e) {
                if (e.target === sidebar) {
                    sidebar.classList.remove('active');
                }
            });

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
