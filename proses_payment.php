<?php

session_start();
include 'koneksi/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$id_pengguna = (int) $_SESSION['user_id'];
$username = $_SESSION['user_name'];

$rental_days = (int) $_SESSION['rental_days'];
$id_kendaraan = (int) $_SESSION['id_kendaraan'];

$metode_pembayaran = isset($_POST['payment']) && !empty($_POST['payment']) ? $_POST['payment'] : 'Tunai';

if (!isset($rental_days) || !isset($id_kendaraan) || !$metode_pembayaran) {
    echo "Data yang diperlukan tidak lengkap.";
    exit();
}

$tanggal_sewa = date('Y-m-d');
$tanggal_sewa_berakhir = date('Y-m-d', strtotime("+$rental_days days"));

if (!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
    echo "Nama pengguna tidak ditemukan. Pastikan Anda sudah login.";
    exit();
}


$sql_vehicle = "SELECT harga_sewa, stok_kendaraan FROM kendaraan WHERE id_kendaraan = $id_kendaraan";
$result_vehicle = mysqli_query($conn, $sql_vehicle);

if ($result_vehicle && mysqli_num_rows($result_vehicle) > 0) {
    $vehicle = mysqli_fetch_assoc($result_vehicle);
    $price_per_day = $vehicle['harga_sewa'];
    $stok_kendaraan = $vehicle['stok_kendaraan'];

    if ($stok_kendaraan > 0) {
        $foto_path = null;

        if (isset($_FILES['buktiTransfer']) && $_FILES['buktiTransfer']['error'] == 0) {
            $target_dir = "assets/transfer/";

            $username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'unknown_user';

            $current_date = date('Ymd');
            $imageFileType = strtolower(pathinfo($_FILES["buktiTransfer"]["name"], PATHINFO_EXTENSION));
            $new_file_name = strtolower(str_replace(' ', '_', $username)) . '-' . $current_date . '.' . $imageFileType;
            $target_file = $target_dir . $new_file_name;

            $check = getimagesize($_FILES["buktiTransfer"]["tmp_name"]);
            if ($check === false) {
                echo "File yang diupload bukan gambar.";
                exit();
            }

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Hanya file gambar yang diperbolehkan (JPG, JPEG, PNG, GIF).";
                exit();
            }

            if (move_uploaded_file($_FILES["buktiTransfer"]["tmp_name"], $target_file)) {
                $foto_path = $new_file_name;
            } else {
                echo "Terjadi kesalahan saat mengupload file.";
                exit();
            }
        }

        $total_harga = $price_per_day * $rental_days;
        $status = "Menunggu Konfirmasi";

        $sql_insert = "INSERT INTO transaksi (id_pengguna, id_kendaraan, tanggal_sewa, total_harga, status, tanggal_sewa_berakhir, metode_pembayaran, foto)
                       VALUES ($id_pengguna, $id_kendaraan, '$tanggal_sewa', $total_harga, '$status', '$tanggal_sewa_berakhir', '$metode_pembayaran', '$foto_path')";

        if (mysqli_query($conn, $sql_insert)) {
            $sql_update_stock = "UPDATE kendaraan SET stok_kendaraan = stok_kendaraan - 1 WHERE id_kendaraan = $id_kendaraan";
            if (!mysqli_query($conn, $sql_update_stock)) {
                echo "Transaksi berhasil disimpan, tetapi terjadi kesalahan saat mengurangi stok kendaraan: " . mysqli_error($conn);
            }

            echo "Transaksi berhasil disimpan!";
            header("Location: index.php");
            exit();
        } else {
            echo "Terjadi kesalahan saat menyimpan transaksi: " . mysqli_error($conn);
        }
    } else {
        echo "Stok kendaraan tidak tersedia.";
    }
} else {
    echo "Data kendaraan tidak ditemukan.";
}

mysqli_close($conn);
?>