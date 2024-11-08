<?php
include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_transaksi = $_POST['id_transaksi'];
    $status_baru = $_POST['status'];

    $query = "SELECT id_kendaraan, status FROM transaksi WHERE id_transaksi = '$id_transaksi'";
    $result = $conn->query($query);

    if ($result) {
        $transaksi = $result->fetch_assoc();

        $id_kendaraan = $transaksi['id_kendaraan'];
        $status_lama = $transaksi['status'];

        $sql = "UPDATE transaksi SET status = '$status_baru' WHERE id_transaksi = '$id_transaksi'";
        if ($conn->query($sql) === TRUE) {
            if ($status_baru === 'Selesai' && $status_lama !== 'Selesai') {
                $sql_update_stock = "UPDATE kendaraan SET stok_kendaraan = stok_kendaraan + 1 WHERE id_kendaraan = $id_kendaraan";
                if ($conn->query($sql_update_stock) === TRUE) {
                    echo "Stok kendaraan berhasil diperbarui.";
                } else {
                    echo "Terjadi kesalahan saat mengupdate stok kendaraan: " . $conn->error;
                }
            } elseif ($status_lama === 'Selesai' && $status_baru === 'Selesai') {
                echo "Status sudah 'selesai', stok kendaraan tidak perlu diperbarui.";
            }
            header("Location: ../transaksi.php");
            exit();
        } else {
            echo "Terjadi kesalahan saat mengupdate status transaksi: " . $conn->error;
        }
    } else {
        echo "Terjadi kesalahan saat mengambil data transaksi: " . $conn->error;
    }
}
?>
