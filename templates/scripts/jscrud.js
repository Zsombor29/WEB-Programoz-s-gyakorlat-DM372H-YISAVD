const apiUrl = 'api';
let isEditing = false;

document.addEventListener("DOMContentLoaded", () => {
    fetchRendelesek();

    document.getElementById('rendelesForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = document.getElementById('id').value;
        const pizza = document.getElementById('pizza').value;
        const darab = document.getElementById('darab').value;

        const payload = { id: id, pizza: pizza, darab: darab };
        const method = isEditing ? 'PUT' : 'POST';

        try {
            const response = await fetch(apiUrl, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (result.status === 'sikeres') {
                mutatUzenet(result.uzenet, "green");
                formTorles();
                fetchRendelesek();
            } else {
                mutatUzenet("Hiba: " + result.uzenet, "red");
            }

        } catch (error) {
            mutatUzenet("Hálózati hiba!", "red");
        }
    });
});

// READ
async function fetchRendelesek() {
    const response = await fetch(apiUrl);
    const data = await response.json();
    renderTable(data);
}

// TABLE
function renderTable(data) {
    const tbody = document.getElementById('tablaBody');
    tbody.innerHTML = '';

    data.forEach(r => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${r.id}</td>
            <td>${r.pizza}</td>
            <td>${r.darab}</td>
            <td>
                <button onclick="editRendeles(${r.id}, '${r.pizza}', ${r.darab})">Szerkesztés</button>
                <button onclick="deleteRendeles(${r.id})">Törlés</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// EDIT
function editRendeles(id, pizza, darab) {
    document.getElementById('id').value = id;
    document.getElementById('pizza').value = pizza;
    document.getElementById('darab').value = darab;

    document.getElementById('id').readOnly = true;
    isEditing = true;
}

// DELETE
async function deleteRendeles(id) {
    if (!confirm("Biztos törlés?")) return;

    await fetch(apiUrl, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    });

    fetchRendelesek();
}

// RESET
function formTorles() {
    document.getElementById('rendelesForm').reset();
    document.getElementById('id').readOnly = false;
    isEditing = false;
}

// MESSAGE
function mutatUzenet(szoveg, szin) {
    const div = document.getElementById('uzenet');
    div.textContent = szoveg;
    div.style.color = szin;
    setTimeout(() => div.textContent = '', 3000);
}