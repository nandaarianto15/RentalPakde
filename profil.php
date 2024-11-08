<?php
session_start();
include 'koneksi/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Anda belum login.";
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM pengguna WHERE id_pengguna = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="assets/styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>

    <?php include 'assets/components/navbar.php' ?>

    <section class="profile-section">
        <h1 class="profile-title">Profil Saya</h1>
        <form id="updateProfileForm" class="profile-form" action="proses_update_profil.php" method="POST">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="<?php echo $user['nama']; ?>" placeholder="Nama Lengkap">
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" placeholder="Email">
            
            <label for="nomor_telepon">Nomor Telepon</label>
            <input type="tel" id="nomor_telepon" name="nomor_telepon" value="<?php echo $user['nomor_telepon']; ?>" placeholder="Nomor Telepon">
            
            <label for="address">Alamat</label>
            <textarea id="address" name="address" rows="3" placeholder="Alamat"><?php echo $user['alamat']; ?></textarea>
            
            <label>Jenis Kelamin</label>
            <div class="gender-options">
                <label class="radio-container">
                    <input type="radio" name="gender" value="Laki-laki" <?php echo ($user['gender'] == 'Laki-laki') ? 'checked' : ''; ?> required>
                    <span class="radio-label">Laki-laki</span>
                </label>
                <label class="radio-container">
                    <input type="radio" name="gender" value="Perempuan" <?php echo ($user['gender'] == 'Perempuan') ? 'checked' : ''; ?> required>
                    <span class="radio-label">Perempuan</span>
                </label>
            </div>

            <label for="birthdate">Tanggal Lahir</label>
            <input type="date" id="birthdate" name="birthdate">

            <button type="submit" class="save-button">Simpan</button>
        </form>
    </section>

    <?php include 'assets/components/footer.php' ?>

    <script>
        document.getElementById('updateProfileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Berhasil! ' + data.message);
                    window.location.reload();
                } else {
                    alert('Oops... ' + data.message);
                }
            })
            .catch(error => {
                alert('Oops... Terjadi kesalahan! Silakan coba lagi.');
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const hamburger = document.getElementById('hamburger');
            const sidebar = document.getElementById('sidebar');
            const closeBtn = document.getElementById('close-btn');

            hamburger.addEventListener('click', function () {
                sidebar.classList.add('active');
            });

            closeBtn.addEventListener('click', function () {
                sidebar.classList.remove('active');
            });

            window.addEventListener('click', function (e) {
                if (e.target === sidebar) {
                    sidebar.classList.remove('active');
                }
            });

            const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
            sidebarLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    sidebar.classList.remove('active');
                });
            });
        });
    </script>
</body>
</html>
