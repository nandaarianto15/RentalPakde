<?php
include '../koneksi/db.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$query = "SELECT * FROM pengguna";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengguna</title>
    <link rel="stylesheet" href="../assets/styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">    
</head>
<body>

    <?php include '../assets/components/sidebar.php'; ?>

    <div class="main-content">
    <header>
    <h1>Daftar Pengguna</h1>
    <div class="header-right">
        <input type="text" id="searchInput" placeholder="Cari Pengguna..." onkeyup="searchTable()">
    </div>
</header>

        <table id="userTable">
            <thead>
                <tr>
                    <th>ID Pengguna</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['id_pengguna']; ?></td>
                        <td><?php echo $user['nama']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <a href="#" title="Edit" style="color: blue;" onclick="fillUpdateForm('<?php echo $user['id_pengguna']; ?>', '<?php echo $user['nama']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['role']; ?>')">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete/delete-pengguna.php?id=<?php echo $user['id_pengguna']; ?>" title="Delete" style="color: red;" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>

                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

<!-- Modal Tambah Pengguna -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addUserModal')">&times;</span>
        <h2>Tambah Pengguna</h2>
        <form id="addUserForm" method="POST" action="add_user.php">
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="email" name="email" placeholder="Email" required>
            <select name="role" required>
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit"  class="btn-add">Tambah</button>

        </form>
    </div>
</div>


<!-- Modal Update Pengguna -->
<div id="updateUserModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('updateUserModal')">&times;</span>
        <h2>Update Pengguna</h2>
        <form id="updateUserForm" method="POST" action="update/update-pengguna.php">
            <input type="hidden" name="id_pengguna" id="updateId">
            <input type="text" name="nama" id="updateName" placeholder="Nama" required>
            <input type="email" name="email" id="updateEmail" placeholder="Email" required>
            <select name="role" id="updateRole" required>
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <input type="password" name="password" id="updatePassword" placeholder="Password (Kosongkan jika tidak ingin mengubah)">
            <button type="submit" class="btn-add">Update</button>

        </form>
    </div>
</div>

    <script src="../assets/js/pengguna.js"></script>
</body>
</html>
