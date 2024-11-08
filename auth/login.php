<?php
session_start();
include '../koneksi/db.php'; 

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM pengguna WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_pengguna'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_name'] = $user['nama']; 
            
            if ($user['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            $error = "Email atau password salah.";
        }
    } else {
        $error = "Email atau password salah.";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/styles/login.css">
</head>
<body>
    <div class="card">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="email" id="email" name="email" required placeholder="Email">
            <input type="password" id="password" name="password" required placeholder="Password">
            <button type="submit">Login</button>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </form>
        <p class="link">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>
