// assets/js/histori-pengguna.js
document.addEventListener('DOMContentLoaded', function() {
    const statusElements = document.querySelectorAll('.status-cancelled');
    statusElements.forEach(status => {
        status.addEventListener('click', () => {
            alert('Transaksi telah dibatalkan.');
        });
    });
});
``