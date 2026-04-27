const apiUrl = './logicals/api.php';
let isEditing = false;
let eredetiFelvetel = null;

document.addEventListener("DOMContentLoaded", () => {
    fetchRendelesek();

    const form = document.getElementById('rendelesForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const payload = {
            pizzanev: document.getElementById('pizzanev').value,
            darab: document.getElementById('darab').value,
            eredetiFelvetel: eredetiFelvetel
        };

        const method = isEditing ? 'PUT' : 'POST';

        try {
            const response = await fetch(apiUrl, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (result.status === 'sikeres') {
                mutatUzenet(result.uzenet, 'green');
                formTorles();
                fetchRendelesek();
            } else {
                mutatUzenet('Hiba: ' + result.uzenet, 'red');
            }
        } catch (error) {
            mutatUzenet('Hálózati hiba történt!', 'red');
        }
    });
});

async function fetchRendelesek() {
    try {
        const response = await fetch(apiUrl);
        const data = await response.json();
        renderTable(data);
    } catch (error) {
        mutatUzenet('Hiba az adatok betöltésekor!', 'red');
    }
}

function renderTable(data) {
    const tbody = document.getElementById('rendelesTablaBody');
    tbody.innerHTML = '';

    data.forEach(rendeles => {
        const tr = document.createElement('tr');

        tr.innerHTML = `
            <td style="padding:10px;">${escapeHtml(rendeles.pizzanev)}</td>
            <td style="padding:10px;">${escapeHtml(rendeles.darab)}</td>
            <td style="padding:10px;">${escapeHtml(rendeles.felvetel)}</td>
            <td style="padding:10px;">${escapeHtml(rendeles.kiszallitas)}</td>
            <td style="padding:10px;">
                <button type="button" onclick="editRendeles('${jsEscape(rendeles.pizzanev)}', '${jsEscape(rendeles.darab)}', '${jsEscape(rendeles.felvetel)}')">Szerkesztés</button>
                <button type="button" onclick="deleteRendeles('${jsEscape(rendeles.felvetel)}')">Törlés</button>
            </td>
        `;

        tbody.appendChild(tr);
    });
}

function editRendeles(pizzanev, darab, felvetel) {
    document.getElementById('pizzanev').value = pizzanev;
    document.getElementById('darab').value = darab;

    eredetiFelvetel = felvetel;
    isEditing = true;
    document.getElementById('mentesGomb').textContent = 'Módosítás';
}

async function deleteRendeles(felvetel) {
    if (!confirm('Biztosan törölni szeretnéd?')) return;

    try {
        const response = await fetch(apiUrl, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ felvetel: felvetel })
        });

        const result = await response.json();

        if (result.status === 'sikeres') {
            mutatUzenet(result.uzenet, 'green');
            fetchRendelesek();
        } else {
            mutatUzenet('Hiba a törlésnél!', 'red');
        }
    } catch (error) {
        mutatUzenet('Hálózati hiba történt!', 'red');
    }
}

function formTorles() {
    document.getElementById('rendelesForm').reset();
    eredetiFelvetel = null;
    isEditing = false;
    document.getElementById('mentesGomb').textContent = 'Mentés';
}

function mutatUzenet(szoveg, szin) {
    const div = document.getElementById('uzenet');
    div.textContent = szoveg;
    div.style.color = szin;

    setTimeout(() => {
        div.textContent = '';
    }, 3000);
}

function escapeHtml(text) {
    return String(text ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#39;');
}

function jsEscape(text) {
    return String(text ?? '')
        .replaceAll('\\', '\\\\')
        .replaceAll("'", "\\'");
}