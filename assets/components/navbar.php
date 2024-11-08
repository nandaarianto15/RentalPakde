<header class="header">
    <img src="assets/images/logo.png" alt="Logo" class="logo">
    
    <nav class="navbar">
        <a href="index.php">Beranda</a>
        <a href="#about-us">Tentang Kami</a>
        <a href="#hubungi-kami">Hubungi Kami</a>
        <a href="#maps">Lokasi Kami</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="histori-pengguna.php">Riwayat Transaksi</a>            
            <a href="profil.php" class="btn">
                <i class="fas fa-user"></i>
                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </a>
            
            <?php if (basename($_SERVER['PHP_SELF']) == "profil.php"): ?>
                <a href="auth/logout.php" class="btn">Logout</a>
            <?php endif; ?>

        <?php else: ?>
            <a href="auth/login.php" class="btn">Login</a>
        <?php endif; ?>
    </nav>
    
    <div class="hamburger" id="hamburger">
        <i class="fas fa-bars"></i>
    </div>
</header>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <span class="close-btn" id="close-btn">&times;</span>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php">Beranda</a>
        <a href="#about-us">Tentang Kami</a>
        <a href="#hubungi-kami">Hubungi Kami</a>
        <a href="#maps">Lokasi Kami</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="histori-pengguna.php">Riwayat Transaksi</a>            
            <a href="profil.php">
                <i class="fas fa-user"></i>
                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </a>
            
            <?php if (basename($_SERVER['PHP_SELF']) == "profil.php"): ?>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="auth/login.php">Login</a>
        <?php endif; ?>
    </nav>
</div>
