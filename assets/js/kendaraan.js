function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function fillUpdateForm(id, nama, jenis, tahun, stok, harga_sewa, gambar) {
    document.getElementById("updateId").value = id;
    document.getElementById("updateNamaKendaraan").value = nama;
    document.getElementById("updateTahun").value = tahun;
    document.getElementById("updateStok").value = stok;
    document.getElementById("updateHargaSewa").value = harga_sewa;
    document.getElementById("updateJenis").value = jenis;

    openModal('updateKendaraanModal');
}


function searchTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#kendaraanTable tbody tr");
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

