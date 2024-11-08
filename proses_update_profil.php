<?php
session_start();
include 'koneksi/db.php';

function sendResponse($status, $message) {
    echo json_encode([
        'status' => $status,
        'message' => $message
    ]);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    sendResponse('error', 'Anda belum login. Silakan login terlebih dahulu!');
}

$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$nomor_telepon = $_POST['nomor_telepon'] ?? null;
$address = $_POST['address'] ?? null;
$gender = $_POST['gender'] ?? null;
$user_id = $_SESSION['user_id'];

if (empty($name) || empty($email) || empty($nomor_telepon) || empty($address) || empty($gender)) {
    sendResponse('error', 'Semua kolom harus diisi!');
}

$sql_update = "UPDATE pengguna SET 
               nama = ?,
               email = ?,
               nomor_telepon = ?, 
               alamat = ?, 
               gender = ? 
               WHERE id_pengguna = ?";
               
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param('sssssi', $name, $email, $nomor_telepon, $address, $gender, $user_id);

if ($stmt_update->execute()) {
    sendResponse('success', 'Profil berhasil diperbarui!');
} else {
    sendResponse('error', 'Gagal memperbarui profil: ' . $stmt_update->error);
}

// Tutup koneksi
$stmt_update->close();
$conn->close();
?>