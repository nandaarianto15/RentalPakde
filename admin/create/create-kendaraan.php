<?php
include '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kendaraan = $_POST['nama_kendaraan'];
    $jenis = $_POST['jenis'];
    $harga_sewa = $_POST['harga_sewa'];
    $stok = $_POST['stok'];
    $tahun = $_POST['tahun']; 

    $nama_kendaraan = str_replace(' ', '-', $nama_kendaraan);
    
    $file_extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
    
    $new_file_name = $nama_kendaraan . '-' . $tahun . '.' . $file_extension;
    
    $target_dir = "../../assets/uploads/";
    $target_file = $target_dir . $new_file_name;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        $query = "INSERT INTO kendaraan (nama_kendaraan, jenis_kendaraan, foto, tahun_kendaraan, stok_kendaraan, harga_sewa) VALUES ('$nama_kendaraan', '$jenis', '$new_file_name', '$tahun', '$stok', '$harga_sewa')";
        if ($conn->query($query) === TRUE) {
            echo "Kendaraan berhasil ditambahkan.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: File tidak dapat diunggah.";
    }

    header("Location: ../kendaraan.php");
    exit();
}
?>
