<?php
include '../../koneksi/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM pengguna WHERE id_pengguna='$id'";
    
    if ($conn->query($query) === TRUE) {
        header("Location: ../pengguna.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
