<?php
include '../koneksi/db.php';

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user';

    $sql = "SELECT * FROM pengguna WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email sudah terdaftar!');</script>";
    } else {
        $sql = "INSERT INTO pengguna (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registrasi berhasil! Silakan login.');</script>";
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <link rel="stylesheet" href="../assets/styles/login.css"> <!-- Link ke file CSS -->
</head>
<body>
    <div class="card">
        <h2>Registrasi</h2>
        <form method="POST">
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Daftar</button>
        </form>
        <div class="link">
            <p>Sudah punya akun? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
