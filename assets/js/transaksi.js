function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function fillUpdateForm(id, namaPengguna, kendaraan, tanggalSewa, status, totalHarga) {
    document.getElementById("updateTransactionId").value = id;
    document.getElementById("updateNamaPengguna").value = namaPengguna;
    document.getElementById("updateKendaraan").value = kendaraan;
    document.getElementById("updateTanggalSewa").value = tanggalSewa;
    document.getElementById("updateStatus").value = status;
    document.getElementById("updateTotalHarga").value = totalHarga;
    openModal('updateTransactionModal');
}


function searchTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#transactionTableBody tr");
    rows.forEach(row => {
        const cells = row.getElementsByTagName("td");
        let rowContainsSearchText = false;
        for (let cell of cells) {
            if (cell.innerText.toLowerCase().includes(input)) {
                rowContainsSearchText = true;
                break;
            }
        }
        row.style.display = rowContainsSearchText ? "" : "none";
    });
}