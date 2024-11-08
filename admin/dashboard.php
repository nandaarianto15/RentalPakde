<?php
include '../koneksi/db.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Ambil total pengguna
$total_pengguna_query = "SELECT COUNT(*) AS total FROM pengguna";
$total_pengguna_result = $conn->query($total_pengguna_query);
$total_pengguna = $total_pengguna_result->fetch_assoc()['total'];

// Ambil total kendaraan
$total_kendaraan_query = "SELECT COUNT(*) AS total FROM kendaraan";
$total_kendaraan_result = $conn->query($total_kendaraan_query);
$total_kendaraan = $total_kendaraan_result->fetch_assoc()['total'];

// Ambil total transaksi
$total_transaksi_query = "SELECT COUNT(*) AS total FROM transaksi";
$total_transaksi_result = $conn->query($total_transaksi_query);
$total_transaksi = $total_transaksi_result->fetch_assoc()['total'];

// Ambil aktivitas terbaru
$recent_activity_query = "
    SELECT t.id_transaksi, p.nama, k.nama_kendaraan, t.status 
    FROM transaksi t 
    JOIN pengguna p ON t.id_pengguna = p.id_pengguna 
    JOIN kendaraan k ON t.id_kendaraan = k.id_kendaraan 
    ORDER BY t.tanggal_sewa DESC 
    LIMIT 5"; // Ambil 5 aktivitas terbaru
$recent_activity_result = $conn->query($recent_activity_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include '../assets/components/sidebar.php' ?>
    <div class="main-content">
        <header>
            <h1>Dashboard</h1>
            <div class="header-right">
                <p>Welcome, Admin </p>
                <a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>
        <div class="dashboard-cards">
            <div class="card">
                <i class="fas fa-users"></i>
                <h3>Total Pengguna</h3>
                <p><?php echo $total_pengguna; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-car"></i>
                <h3>Total Kendaraan</h3>
                <p><?php echo $total_kendaraan; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-receipt"></i>
                <h3>Total Transaksi</h3>
                <p><?php echo $total_transaksi; ?></p>
            </div>
        </div>
        <div class="recent-activity">
            <h2>Aktivitas Terbaru</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Nama Pengguna</th>
                        <th>Kendaraan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($activity = $recent_activity_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $activity['id_transaksi']; ?></td>
                            <td><?php echo $activity['nama']; ?></td>
                            <td><?php echo $activity['nama_kendaraan']; ?></td>
                            <td><?php echo $activity['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close(); // Tutup koneksi database
?>
