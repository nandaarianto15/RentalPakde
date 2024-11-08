<?php
include '../koneksi/db.php';

if (!isset($_GET['id'])) {
    header("Location: transaksi.php");
    exit();
}

$id_transaksi = $_GET['id'];

$query = "SELECT t.id_transaksi, u.nama AS nama_pengguna, u.nomor_telepon AS telepon, k.nama_kendaraan, t.tanggal_sewa, t.tanggal_sewa_berakhir, t.total_harga, t.status, t.foto
          FROM transaksi t
          JOIN pengguna u ON t.id_pengguna = u.id_pengguna
          JOIN kendaraan k ON t.id_kendaraan = k.id_kendaraan
          WHERE t.id_transaksi = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_transaksi);
$stmt->execute();
$result = $stmt->get_result();
$transaction = $result->fetch_assoc();

if (!$transaction) {
    echo "Transaksi tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .detail-item {
            margin-bottom: 15px;
        }

        .detail-item strong {
            display: inline-block;
            width: 200px;
            color: #555;
        }

        .detail-item span {
            color: #333;
        }

        img {
            display: block;
            margin-top: 10px;
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .btn {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .btn a {
            background-color: #ff4d4f;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin: 0 10px;
            transition: background-color 0.3s ease;
        }

        .btn a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Detail Transaksi</h1>
    
    <div class="detail-item">
        <strong>Nama Pengguna:</strong> <span><?php echo $transaction['nama_pengguna']; ?></span>
    </div>
    <div class="detail-item">
        <strong>Telepon:</strong> <span><?php echo $transaction['telepon']; ?></span>
    </div>
    <div class="detail-item">
        <strong>Kendaraan:</strong> <span><?php echo $transaction['nama_kendaraan']; ?></span>
    </div>
    <div class="detail-item">
        <strong>Tanggal Sewa:</strong> <span><?php echo $transaction['tanggal_sewa']; ?></span>
    </div>
    <div class="detail-item">
        <strong>Tanggal Sewa Berakhir:</strong> <span><?php echo $transaction['tanggal_sewa_berakhir']; ?></span>
    </div>
    <div class="detail-item">
        <strong>Total Harga:</strong> <span>Rp <?php echo number_format($transaction['total_harga'], 0, ',', '.'); ?></span>
    </div>
    <div class="detail-item">
        <strong>Status:</strong> <span><?php echo $transaction['status']; ?></span>
    </div>

    <div class="detail-item">
        <strong>Bukti Transfer:</strong>
        <?php if ($transaction['foto']): ?>
            <img src="../assets/transfer/<?php echo $transaction['foto']; ?>" alt="Bukti Transfer" width="60%">
        <?php else: ?>
            <p>Tidak ada bukti transfer.</p>
        <?php endif; ?>
    </div>

    <div class="btn">
        <a href="transaksi.php">Kembali ke Daftar Transaksi</a>
    </div>
</div>

</body>
</html>
