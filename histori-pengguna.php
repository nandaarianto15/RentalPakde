<!-- histori-pengguna.php -->
<?php
session_start();
include 'koneksi/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$sql = "SELECT t.id_transaksi, k.nama_kendaraan, k.foto, t.total_harga, t.tanggal_sewa, t.tanggal_sewa_berakhir, t.Metode_pembayaran, t.status 
        FROM transaksi t
        JOIN kendaraan k ON t.id_kendaraan = k.id_kendaraan
        WHERE t.id_pengguna = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link rel="stylesheet" href="assets/styles/main.css">
    <link rel="stylesheet" href="assets/styles/histori-pengguna.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'assets/components/navbar.php'; ?>

    <h2> Riwayat Transaksi</h2>
  
    <div class="container">
        <table class="transaction-table">
            <thead>
                <tr>
                    <th>Gambar Kendaraan</th>
                    <th>Nama Kendaraan</th>
                    <th>Total Bayar</th>
                    <th>Tanggal Sewa</th>
                    <th>Tanggal Berakhir</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($transaction = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="assets/uploads/<?php echo htmlspecialchars($transaction['foto']); ?>" alt="<?php echo htmlspecialchars($transaction['nama_kendaraan']); ?>"></td>
                        <td><?php echo htmlspecialchars(str_replace('-', ' ', $transaction['nama_kendaraan'])); ?></td>
                        <td>Rp <?php echo number_format($transaction['total_harga'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($transaction['tanggal_sewa']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['tanggal_sewa_berakhir']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['Metode_pembayaran']); ?></td>
                        <td class="status-<?php echo strtolower($transaction['status']); ?>"><?php echo htmlspecialchars($transaction['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
  
    <?php include 'assets/components/footer.php'; ?> 
    
    <script src="assets/js/histori-pengguna.js"></script>
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

<?php $conn->close(); ?>
