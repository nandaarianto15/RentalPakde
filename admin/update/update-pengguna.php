<?php
include '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_pengguna'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    if ($password) {
        $query = "UPDATE pengguna SET nama='$nama', email='$email', role='$role', password='$password' WHERE id_pengguna='$id'";
    } else {
        $query = "UPDATE pengguna SET nama='$nama', email='$email', role='$role' WHERE id_pengguna='$id'";
    }

    if ($conn->query($query) === TRUE) {
        header("Location: ../pengguna.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
