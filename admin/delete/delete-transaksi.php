<?php
include '../../koneksi/db.php';

if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $query = "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'";
    
    if ($conn->query($query) === TRUE) {
        header("Location: ../transaksi.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
