function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function fillUpdateForm(id, name, email, role) {
    document.getElementById("updateId").value = id;
    document.getElementById("updateName").value = name;
    document.getElementById("updateEmail").value = email;
    document.getElementById("updateRole").value = role;
    openModal('updateUserModal');
}

function searchTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#userTableBody tr");
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