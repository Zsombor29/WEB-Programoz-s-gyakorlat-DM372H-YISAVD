const apiUrl = './logicals/api.php';
let isEditing = false;

document.addEventListener("DOMContentLoaded", () => {
    fetchRendelesek();

    const form = document.getElementById('rendelesForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const az = document.getElementById('az').value;
        const pizzanev = document.getElementById('pizzanev').value;
        const darab = document.getElementById('darab').value;
        const meret = document.getElementById('meret').value;
        const vevonev = document.getElementById('vevonev').value;

        const payload = { az, pizzanev, darab, meret, vevonev };
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
            mutatUzenet("Hálózati hiba történt!", "red");
        }
    });
});

async function fetchRendelesek() {
    try {
        const response = await fetch(apiUrl);
        const data = await response.json();
        renderTable(data);
    } catch (error) {
        mutatUzenet("Hiba az adatok betöltésekor!", "red");
    }
}

function renderTable(data) {
    const tbody = document.getElementById('rendelesTablaBody');
    if (!tbody) return;
    tbody.innerHTML = '';

    data.forEach(rendeles => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${rendeles.az}</td>
            <td>${rendeles.pizzanev}</td>
            <td>${rendeles.darab}</td>
            <td>${rendeles.meret}</td>
            <td>${rendeles.vevonev}</td>
            <td>
                <button onclick="editRendeles(${rendeles.az}, '${String(rendeles.pizzanev).replace(/'/g, "\\'")}', ${rendeles.darab}, '${String(rendeles.meret).replace(/'/g, "\\'")}', '${String(rendeles.vevonev).replace(/'/g, "\\'")}')">Szerkesztés</button>
                <button onclick="deleteRendeles(${rendeles.az})">Törlés</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function editRendeles(az, pizzanev, darab, meret, vevonev) {
    document.getElementById('az').value = az;
    document.getElementById('pizzanev').value = pizzanev;
    document.getElementById('darab').value = darab;
    document.getElementById('meret').value = meret;
    document.getElementById('vevonev').value = vevonev;

    document.getElementById('az').readOnly = true;
    isEditing = true;
    document.getElementById('mentesGomb').textContent = "Módosítás";
}

async function deleteRendeles(az) {
    if (!confirm("Biztosan törölni szeretnéd?")) return;

    try {
        const response = await fetch(apiUrl, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ az })
        });

        const result = await response.json();

        if (result.status === 'sikeres') {
            mutatUzenet(result.uzenet, "green");
            fetchRendelesek();
        } else {
            mutatUzenet("Hiba a törlésnél!", "red");
        }
    } catch (error) {
        mutatUzenet("Hálózati hiba történt!", "red");
    }
}

function formTorles() {
    document.getElementById('rendelesForm').reset();
    document.getElementById('az').value = '';
    document.getElementById('az').readOnly = false;
    isEditing = false;
    document.getElementById('mentesGomb').textContent = "Mentés";
}

function mutatUzenet(szoveg, szin) {
    const div = document.getElementById('uzenet');
    if (!div) return;
    div.textContent = szoveg;
    div.style.color = szin;
    setTimeout(() => div.textContent = '', 3000);
}
