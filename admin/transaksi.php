<?php
include '../koneksi/db.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$query = "SELECT t.id_transaksi, u.nama AS nama_pengguna, u.nomor_telepon AS telepon, k.nama_kendaraan, t.tanggal_sewa, t.total_harga, t.status, t.foto
          FROM transaksi t
          JOIN pengguna u ON t.id_pengguna = u.id_pengguna
          JOIN kendaraan k ON t.id_kendaraan = k.id_kendaraan";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Pesanan - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    .btn {
        padding: 8px 16px;
        background-color: #ff4d4f;
        border-radius: 4px;
        text-decoration: none;
        border: none;
        color: white;
        font-weight: 500;
    }
</style>
<body>
    <?php include '../assets/components/sidebar.php' ?>

    <div class="main-content">
        <header>
            <h1>Daftar Transaksi Pesanan</h1>
            <div class="header-right">
                <input type="text" id="searchInput" placeholder="Cari Transaksi..." onkeyup="searchTable()">
            </div>
        </header>

        <table id="transactionTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Kendaraan</th>
                    <th>Sewa Awal</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Detail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="transactionTableBody">
                <?php while ($transaction = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $transaction['id_transaksi']; ?></td>
                        <td><?php echo $transaction['nama_pengguna']; ?></td>
                        <td><?php echo $transaction['telepon']; ?></td>
                        <td><?php echo $transaction['nama_kendaraan']; ?></td>
                        <td><?php echo $transaction['tanggal_sewa']; ?></td>
                        <td>Rp<?php echo number_format($transaction['total_harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $transaction['status']; ?></td>
                        <td>
                            <a href="detail-transaksi.php?id=<?php echo $transaction['id_transaksi']; ?>" title="Detail" style="color: green;">
                                <button class="btn">
                                    Detail
                                </button>
                            </a>
                        </td>
                        <td>
                            <a href="#" onclick="fillUpdateForm('<?php echo $transaction['id_transaksi']; ?>', '<?php echo $transaction['nama_pengguna']; ?>', '<?php echo $transaction['nama_kendaraan']; ?>', '<?php echo $transaction['tanggal_sewa']; ?>', '<?php echo $transaction['status']; ?>', '<?php echo $transaction['total_harga']; ?>')" title="Edit" style="color: blue;">
                                    <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete/delete-transaksi.php?id_transaksi=<?php echo $transaction['id_transaksi']; ?>" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');" style="color: red;">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>

    <div id="updateTransactionModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('updateTransactionModal')">&times;</span>
            <h2 style="margin-bottom: 5%;">Update Transaksi</h2>
            <form id="updateTransactionForm" method="POST" action="update/update-transaksi.php">
                <input type="hidden" name="id_transaksi" id="updateTransactionId">

                <div>
                    <label for="">Nama Pengguna</label>
                    <input type="text" id="updateNamaPengguna" name="namaPengguna" disabled>
                </div>

                <div>
                    <label for="">Kendaraan</label>
                    <input type="text" id="updateKendaraan" disabled>
                </div>

                <div>
                    <label for="">Tanggal Sewa</label>
                    <input type="date" id="updateTanggalSewa" disabled>
                </div>

                <div>
                    <label for="">Total Harga</label>
                    <input type="text" id="updateTotalHarga" disabled>
                </div>
                
                <div>
                    <label for="">Status</label>
                    <select name="status" id="updateStatus">
                        <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                        <option value="Menyewa">Menyewa</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>


                <button type="submit" class="btn-add">Update</button>
            </form>
        </div>
    </div>

    <script src="../assets/js/transaksi.js"></script>
</body>
</html>
