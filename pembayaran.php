<?php
session_start();
include 'koneksi/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$id_pengguna = (int) $_SESSION['user_id'];

$sql = "SELECT nama, email, alamat, nomor_telepon FROM pengguna WHERE id_pengguna = $id_pengguna";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $nama_pengguna = mysqli_fetch_assoc($result);
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

if (isset($_POST['rental_days']) && isset($_POST['id_kendaraan'])) {
    $_SESSION['rental_days'] = (int) $_POST['rental_days'];
    $_SESSION['id_kendaraan'] = (int) $_POST['id_kendaraan'];
}

$rental_days = $_SESSION['rental_days'] ?? 1;
$id_kendaraan = (int) $_SESSION['id_kendaraan'];

$sql_vehicle = "SELECT * FROM kendaraan WHERE id_kendaraan = $id_kendaraan";
$result_vehicle = mysqli_query($conn, $sql_vehicle);

if ($result_vehicle && mysqli_num_rows($result_vehicle) > 0) {
    $vehicle = mysqli_fetch_assoc($result_vehicle);
    $vehicle_name = $vehicle['nama_kendaraan'];
    $price_per_day = $vehicle['harga_sewa'];
    $vehicle_image = $vehicle['foto'];
    $total_price = $price_per_day * $rental_days;
} else {
    echo "Data kendaraan tidak ditemukan.";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="assets/styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <?php include 'assets/components/navbar.php' ?>

    <div class="container">
        <section class="billing-details">
            <h2>Billing Details</h2>
            <form action="proses_payment.php" method="POST" enctype="multipart/form-data">
                <div class="billing-form">
                    <div class="billing-form-left">
                        <div class="form-group">
                            <label>Nama Lengkap:</label>
                            <input type="text" name="nama" value="<?php echo htmlspecialchars($nama_pengguna['nama']); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($nama_pengguna['email']); ?>" disabled>
                        </div>
                    </div>
                    <div class="billing-form-right">
                        <div class="form-group">
                            <label>Alamat:</label>
                            <input type="text" name="alamat" value="<?php echo htmlspecialchars($nama_pengguna['alamat']); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Telepon:</label>
                            <input type="tel" name="telepon" value="<?php echo htmlspecialchars($nama_pengguna['nomor_telepon']); ?>" disabled>
                        </div>
                    </div>
                </div>
        </section>

        <aside class="rental-detail">
            <h2>Rental Detail</h2>
            <div class="car-info">
                <img src="assets/uploads/<?php echo htmlspecialchars($vehicle_image); ?>" alt="Vehicle Image">
                <h4><?php echo htmlspecialchars(str_replace('-', ' ', $vehicle_name)); ?>
                </h4>
            </div>
            <div class="price-info">
                <h3>Harga per Hari</h3>  
                <h4><?php echo number_format($price_per_day, 0, ',', '.'); ?></h4>
            </div>
            <div class="total-day-rent">
                <h3>Total Hari</h3>
                <h4><?php echo $rental_days; ?> hari</h4>
            </div>
            <div class="total-price">
                <h3>Total Harga</h3>
                <h3>Rp<?php echo number_format($total_price, 0, ',', '.'); ?></h3>
            </div>
        </aside>
    </div>

    <section class="payment-method">
        <h2>Metode Pembayaran</h2>
        <p>Pilih metode pembayaran anda</p>

        <div class="payment-options">
            <div class="option">
                <div class="option-header">
                    <div class="option-header-left">
                        <span class="option-icon"><i class="fas fa-university"></i></span>
                        <span>Transfer Bank</span>
                    </div>
                    <span class="chevron"></span>
                </div>
                <div class="option-content">
                    <ul>
                        <li>
                            <input type="radio" name="payment" id="mandiri" value="Mandiri" onclick="checkPaymentMethod()">
                            <label for="mandiri">Bank Mandiri - 123456789</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="bca" value="BCA" onclick="checkPaymentMethod()">
                            <label for="bca">Bank BCA - 123456789</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="bni" value="BNI" onclick="checkPaymentMethod()">
                            <label for="bni">Bank BNI - 123456789</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="bri" value="BRI" onclick="checkPaymentMethod()">
                            <label for="bri">Bank BRI - 123456789</label>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="option">
                <div class="option-header">
                    <div class="option-header-left">
                        <span class="option-icon"><i class="fas fa-money-bill-wave"></i></span>
                        <span>Cash</span>
                    </div>
                    <span class="chevron"></span>
                </div>
                <div class="option-content">
                    <p>Silahkan lakukan pembayaran di tempat.</p>
                    <input type="radio" name="payment" id="cash" value="Cash" onclick="checkPaymentMethod()">
                    <label for="cash">Bayar Tunai</label>
                </div>
            </div>
        </div>

        <div>
            <h2>Kirim Bukti Transfer</h2>
            <input type="file" name="buktiTransfer" id="buktiTransfer">
        </div>
    </section>

    <section class="confirmation">
        <h2>Konfirmasi</h2>
        <div class="confirmation-checkbox">
            <input type="checkbox" id="confirm" required>
            <label for="confirm">Saya setuju dengan syarat dan ketentuan.</label><br><br>
        </div>
        <button id="back-btn" class="back-btn" type="button"a onclick="history.back()">Kembali</button>
        <button id="order-btn" class="order-btn" type="submit">Pesan Sekarang</button>
    </section>
    
    </form>

    <?php include 'assets/components/footer.php' ?>

    <script>
        function initPaymentAccordion() {
            document.querySelectorAll('.option-header').forEach(header => {
                header.addEventListener('click', () => {
                    const option = header.parentElement;
                    const content = header.nextElementSibling;
                    
                    option.classList.toggle('active');
                    
                    document.querySelectorAll('.option').forEach(otherOption => {
                        if (otherOption !== option) {
                            otherOption.classList.remove('active');
                        }
                    });
                });
            });
        }
        document.addEventListener('DOMContentLoaded', initPaymentAccordion);

        function checkPaymentMethod() {
            const paymentOptions = document.getElementsByName('payment');
            const buktiTransfer = document.getElementById('buktiTransfer');
            
            let isBankTransfer = false;
            
            // Periksa jika ada metode pembayaran transfer yang dipilih
            for (const option of paymentOptions) {
                if (option.checked && option.value !== 'Cash') {
                    isBankTransfer = true;
                    break;
                }
            }

            // Atur 'required' pada input file berdasarkan metode pembayaran yang dipilih
            if (isBankTransfer) {
                buktiTransfer.required = true;
            } else {
                buktiTransfer.required = false;
            }
        }
    </script>
</body>
</html>
