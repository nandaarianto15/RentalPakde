<?php
include '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kendaraan = $_POST['id_kendaraan'];
    $nama_kendaraan = $_POST['nama_kendaraan'];
    $jenis = $_POST['jenis'];
    $harga_sewa = $_POST['harga_sewa'];
    $stok = $_POST['stok'];
    $tahun = $_POST['tahun']; 

    $target_dir = "../../assets/uploads/";

    if ($_FILES['foto']['name']) {
        $query = "SELECT foto FROM kendaraan WHERE id_kendaraan = $id_kendaraan";
        $result = $conn->query($query);
        $current_photo = $result->fetch_assoc()['foto'];

        if ($current_photo && file_exists($target_dir . $current_photo)) {
            unlink($target_dir . $current_photo);
        }

        $nama_kendaraan_formatted = str_replace(' ', '-', $nama_kendaraan);
        $file_extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
        $new_file_name = $nama_kendaraan_formatted . '-' . $tahun . '.' . $file_extension;
        $target_file = $target_dir . $new_file_name;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $query = "UPDATE kendaraan SET nama_kendaraan='$nama_kendaraan', jenis_kendaraan='$jenis', harga_sewa=$harga_sewa, stok_kendaraan=$stok, tahun_kendaraan=$tahun, foto='$new_file_name' WHERE id_kendaraan=$id_kendaraan";
        } else {
            echo "Error: File tidak dapat diunggah.";
            exit();
        }
    } else {
        $query = "UPDATE kendaraan SET nama_kendaraan='$nama_kendaraan', jenis_kendaraan='$jenis', harga_sewa=$harga_sewa, stok_kendaraan=$stok, tahun_kendaraan=$tahun WHERE id_kendaraan=$id_kendaraan";
    }

    if ($conn->query($query) === TRUE) {
        echo "Kendaraan berhasil diupdate.";
    } else {
        echo "Error: " . $conn->error;
    }

    header("Location: ../kendaraan.php");
    exit();
}
?>
