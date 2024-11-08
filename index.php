<?php
session_start();
include 'koneksi/db.php';

if (isset($_SESSION['user_name'])) {
    $namaPengguna = $_SESSION['user_name'];
}

$vehiclesMotor = [];
$vehiclesMobil = [];
$sql = "SELECT id_kendaraan, nama_kendaraan, jenis_kendaraan, harga_sewa, foto FROM kendaraan WHERE stok_kendaraan > 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['jenis_kendaraan'] === 'Motor') {
            $vehiclesMotor[] = $row;
        } elseif ($row['jenis_kendaraan'] === 'Mobil') {
            $vehiclesMobil[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Kendaraan Samarinda</title>
    <link rel="stylesheet" href="assets/styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'assets/components/navbar.php'; ?>

    <div class="hero">
        <div class="hero-text">
            <h1>RENTAL KENDARAAN SAMARINDA</h1>
            <h3>Rental Motor & Mobil Samarinda Terlengkap</h3>
            <h3>dan Termurah Dengan Pelayanan Memuaskan</h3>
            <a href="daftar-kendaraan.php">
                <button class="btn">Pesan Sekarang</button>
            </a>
        </div>
        <img src="assets/images/hero.png" alt="Kendaraan" class="hero-image">
    </div>

    <section class="available-vehicles">
        <h2>Kendaraan Tersedia</h2>

        <!-- Section Motor -->
        <div class="vehicles-category">
            <h3>Motor</h3>
            <div class="vehicles-list">
                <?php if (empty($vehiclesMotor)): ?>
                    <h4 style="text-align: center; font-style: italic;">Tidak ada motor yang tersedia</h4>
                <?php else: ?>
                    <?php foreach ($vehiclesMotor as $vehicle): ?>
                        <a href="detail-produk.php?id_kendaraan=<?php echo $vehicle['id_kendaraan']; ?>" style="text-decoration: none;">
                            <div class="vehicle-item">
                                <img src="assets/uploads/<?php echo $vehicle['foto']; ?>" alt="<?php echo htmlspecialchars($vehicle['nama_kendaraan']); ?>">
                                <p><?php echo htmlspecialchars(str_replace('-', ' ', $vehicle['nama_kendaraan'])); ?></p>
                                <p>Rp<?php echo number_format($vehicle['harga_sewa'], 0, ',', '.'); ?>/hari</p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <a href="daftar-kendaraan.php?jenis_kendaraan=Motor" class="view-all">Lihat Semua</a>
        </div>

        <!-- Section Mobil -->
        <div class="vehicles-category">
            <h3>Mobil</h3>
            <div class="vehicles-list">
                <?php if (empty($vehiclesMobil)): ?>
                    <h4 style="text-align: center; font-style: italic;">Tidak ada mobil yang tersedia</h4>
                <?php else: ?>
                    <?php foreach ($vehiclesMobil as $vehicle): ?>
                        <a href="detail-produk.php?id_kendaraan=<?php echo $vehicle['id_kendaraan']; ?>" style="text-decoration: none;">
                            <div class="vehicle-item">
                                <img src="assets/uploads/<?php echo $vehicle['foto']; ?>" alt="<?php echo htmlspecialchars($vehicle['nama_kendaraan']); ?>">
                                <p><?php echo htmlspecialchars(str_replace('-', ' ', $vehicle['nama_kendaraan'])); ?></p>
                                <p>Rp<?php echo number_format($vehicle['harga_sewa'], 0, ',', '.'); ?>/hari</p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <a href="daftar-kendaraan.php?jenis_kendaraan=Mobil" class="view-all">Lihat Semua</a>
        </div>
    </section>

    <section class="about-us" id="about-us">
        <div class="image-container">
            <img src="assets/images/us.jpg" alt="About Us">
            <div class="highlight">Berdiri Sejak <br> 2021</div>
        </div>
        <div class="about-text">
            <h1>Tentang Kami</h1>
            <h2>Nyalakan mesin & perjalanan Anda dimulai!</h2>
            <p>Pakde Rental hadir untuk memenuhi kebutuhan transportasi Anda di Samarinda dengan layanan lepas kunci. Kami menyediakan berbagai pilihan motor dan mobil berkualitas yang siap Anda gunakan dengan bebas, tanpa batasan rute atau tujuan. Dengan proses penyewaan yang mudah, harga terjangkau, dan kendaraan siap terawat, kami memastikan pengalaman berkendara Anda nyaman dan menyenangkan. Ke manapun perjalanan Anda, Pakde Rental siap membantu!</p>
            <ul>
                <li>
                    <strong>Hemat dan Terjangkau</strong><br>
                    ✔ Kami menawarkan layanan rental kendaraan dengan harga yang kompetitif tanpa mengorbankan kualitas. Dengan berbagai pilihan motor dan mobil, Pakde Rental memastikan Anda mendapatkan solusi transportasi terbaik untuk segala kebutuhan dan anggaran.
                </li>
                <li>
                    <strong>Kepuasan 100%</strong><br>
                    ✔ Kepuasan Anda adalah prioritas kami. Kami berkomitmen memberikan pengalaman sewa terbaik dengan kendaraan yang selalu dalam kondisi prima dan pelayanan ramah agar perjalanan anda terasa nyaman dan memuaskan.
                </li>
                <li>
                    <strong>Aman dan Terpercaya</strong><br>
                    ✔ Kendaraan anda, kebebasan anda. Kami menjamin keamanan dan kenyamanan selama anda menggunakan kendaraan kami. Setiap kendaraan dirawat dengan cermat agar perjalanan anda aman dan tanpa kendala, ke mana pun tujuan anda.
                </li>
            </ul>
        </div>
    </section>

    <section class="rental-process">
        <h2 class="outline">Proses Rental</h2>
        <p class="outline">Penyewaan mobil cepat & mudah</p>
        <p>Ikuti langkah sederhana berikut dan Anda siap berkendara dengan pilihan kendaraan favorit.</p>
        <div class="process-steps">
            <div class="step">
                <h3 class="outline">01</h3>
                <h4>Pilih Kendaraan</h4>
                <p>Pilih kendaraan yang sesuai dengan kebutuhan perjalanan anda.</p>
            </div>
            <div class="step">
                <h3 class="outline">02</h3>
                <h4>Menunggu Dihubungi Admin</h4>
                <p>Setelah pemesanan, tim kami akan segera menghubungi untuk konfirmasi dan memberikan detail lengkap.</p>
            </div>
            <div class="step">
                <h3 class="outline">03</h3>
                <h4>Kendaraan Siap Dibawa</h4>
                <p>Kendaraan sudah siap! Nikmati perjalanan tanpa batas dengan kebebasan penuh bersama Pakde Rental.</p>
            </div>
        </div>
    </section>

    <section class="contact-us-section" id="hubungi-kami">
        <h2>Hubungi Kami</h2>
        <div class="contact-us-container">
            <div class="contact-us-form">
                <div class="form-row">
                    <input type="text" placeholder="Nama">
                </div>
                <div class="form-row">
                    <input type="email" placeholder="Email">
                </div>
                <div class="form-row">
                    <input type="text" placeholder="Telepon">
                </div>
                <div class="form-row">
                    <input type="date" placeholder="mm/dd/yyyy">
                </div>
                <div class="form-row">
                    <textarea placeholder="Pesan"></textarea>
                </div>
                <button class="submit-btn">Kirim Pesan</button>
            </div>
            <div class="contact-us-logo">
                <img src="assets/images/logo.png" alt="Pakde Rental Logo">
            </div>
        </div>
    </section>

    <?php include 'assets/components/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
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
