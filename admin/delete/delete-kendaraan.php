<?php
include '../../koneksi/db.php';

if (isset($_GET['id'])) {
    $id_kendaraan = $_GET['id'];
    $query = "DELETE FROM kendaraan WHERE id_kendaraan='$id_kendaraan'";
    
    if ($conn->query($query) === TRUE) {
        header("Location: ../kendaraan.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
