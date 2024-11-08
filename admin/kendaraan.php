<?php
include '../koneksi/db.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$query = "SELECT * FROM kendaraan";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kendaraan</title>
    <link rel="stylesheet" href="../assets/styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include '../assets/components/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <h1>Daftar Kendaraan</h1>
            <div class="header-right">
                <button onclick="openModal('addKendaraanModal')" class="btn-add">Tambah Kendaraan</button>
                <input type="text" id="searchInput" placeholder="Cari Kendaraan..." onkeyup="searchTable()">
            </div>
        </header>

        <table id="kendaraanTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Harga Sewa</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="kendaraanTableBody">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_kendaraan']; ?></td>
                        <td><?php echo str_replace('-', ' ', $row['nama_kendaraan']); ?></td>
                        <td><?php echo $row['jenis_kendaraan']; ?></td>
                        <td><?php echo $row['tahun_kendaraan']; ?></td>
                        <td><?php echo $row['stok_kendaraan']; ?></td>
                        <td><?php echo $row['harga_sewa']; ?></td>
                        <td><img src="../assets/uploads/<?php echo $row['foto']; ?>" alt="<?php echo $row['nama_kendaraan']; ?>" style="width: 50px; height: auto;"></td>
                        <td>
                            <a href="#" title="Edit" style="color: blue;" onclick="fillUpdateForm('<?php echo $row['id_kendaraan']; ?>', '<?php echo $row['nama_kendaraan']; ?>', '<?php echo $row['jenis_kendaraan']; ?>', '<?php echo $row['tahun_kendaraan']; ?>', '<?php echo $row['stok_kendaraan']; ?>', '<?php echo $row['harga_sewa']; ?>', '<?php echo $row['foto']; ?>')">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete/delete-kendaraan.php?id=<?php echo $row['id_kendaraan']; ?>" title="Delete" style="color: red;" onclick="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Modal Tambah Kendaraan -->
        <div id="addKendaraanModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addKendaraanModal')">&times;</span>
                <h2>Tambah Kendaraan</h2>
                <form id="addKendaraanForm" method="POST" action="create/create-kendaraan.php" enctype="multipart/form-data">
                    <input type="text" name="nama_kendaraan" placeholder="Nama Kendaraan" required>
                    <!-- <input type="text" name="jenis" placeholder="Jenis Kendaraan" required> -->
                    <select name="jenis" id="updateJenis">
                        <option value="Jenis Kendaraan" hidden>Jenis Kendaraan</option>
                        <option value="Motor">Motor</option>
                        <option value="Mobil">Mobil</option>
                    </select>
                    <input type="number" name="tahun" placeholder="Tahun Kendaraan" class="tahun" required><br>
                    <input type="number" name="stok" placeholder="Stok Kendaraan" required>
                    <input type="number" name="harga_sewa" placeholder="Harga Sewa" required>
                    <input type="file" name="foto" accept="image/*" required>
                    <button type="submit" class="btn-add">Tambah</button>
                </form>
            </div>
        </div>

        <!-- Modal Update Kendaraan -->
        <div id="updateKendaraanModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('updateKendaraanModal')">&times;</span>
                <h2 style="margin-bottom: 5%;">Update Kendaraan</h2>
                <form id="updateKendaraanForm" method="POST" action="update/update-kendaraan.php" enctype="multipart/form-data">
                    <input type="hidden" name="id_kendaraan" id="updateId">
                    
                    <div>
                        <label for="">Nama Kendaraan</label>
                        <input type="text" name="nama_kendaraan" id="updateNamaKendaraan" required>
                    </div>
                    <!-- <input type="text" name="jenis" id="updateJenis" placeholder="Jenis" required> -->
                    <div>
                        <label for="">Jenis Kendaraan</label>
                        <select name="jenis" id="updateJenis">
                            <option value="Jenis Kendaraan" hidden>Jenis Kendaraan</option>
                            <option value="Motor">Motor</option>
                            <option value="Mobil">Mobil</option>
                        </select>
                    </div>

                    <div>
                        <label for="">Tahun Kendaraan</label>
                        <input type="number" name="tahun" id="updateTahun" class="tahun" required><br>
                    </div>

                    <div>
                        <label for="">Stok</label>
                        <input type="number" name="stok" id="updateStok" required>
                    </div>

                    <div>
                        <label for="">Harga Sewa</label>
                        <input type="number" name="harga_sewa" id="updateHargaSewa" required>
                    </div>

                    <div>
                        <label for="">Gambar</label>
                        <input type="file" name="foto" id="updateGambar" accept="image/*">
                    </div>
                    <button type="submit" class="btn-add">Update</button>
                </form>
            </div>
        </div>

    </div>

    <script src="../assets/js/kendaraan.js"></script>
</body>
</html>
