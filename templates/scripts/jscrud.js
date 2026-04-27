const apiUrl = './logicals/api.php';
let isEditing = false;

document.addEventListener("DOMContentLoaded", () => {
    fetchRendelesek();

    const form = document.getElementById('rendelesForm');
    if (!form) return;

    beallitAutomatikusIdok();

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const payload = {
            eredetiFelvetel: document.getElementById('eredetiFelvetel').value,
            pizzanev: document.getElementById('pizzanev').value,
            darab: document.getElementById('darab').value,
            felvetel: document.getElementById('felvetel').value,
            kiszallitas: document.getElementById('kiszallitas').value
        };

        const method = isEditing ? 'PUT' : 'POST';

        try {
            const response = await fetch(apiUrl, {
                method,
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
    if (!tbody) return;

    tbody.innerHTML = '';

    data.forEach((rendeles) => {
        const pizzanev = rendeles.pizzanev ?? '';
        const darab = rendeles.darab ?? '';
        const felvetel = rendeles.felvetel ?? '';
        const kiszallitas = rendeles.kiszallitas ?? '';

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td style="padding:10px; word-wrap:break-word;">${escapeHtml(pizzanev)}</td>
            <td style="padding:10px;">${escapeHtml(String(darab))}</td>
            <td style="padding:10px;">${escapeHtml(felvetel)}</td>
            <td style="padding:10px;">${escapeHtml(kiszallitas)}</td>
            <td style="padding:10px;">
                <button type="button" onclick="editRendeles(
                    '${jsEscape(pizzanev)}',
                    '${jsEscape(String(darab))}',
                    '${jsEscape(felvetel)}',
                    '${jsEscape(kiszallitas)}'
                )">Szerkesztés</button>
                <button type="button" onclick="deleteRendeles('${jsEscape(felvetel)}')">Törlés</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function editRendeles(pizzanev, darab, felvetel, kiszallitas) {
    document.getElementById('eredetiFelvetel').value = felvetel;
    document.getElementById('pizzanev').value = pizzanev;
    document.getElementById('darab').value = darab;
    document.getElementById('felvetel').value = felvetel;
    document.getElementById('kiszallitas').value = kiszallitas;

    isEditing = true;
    document.getElementById('mentesGomb').textContent = 'Módosítás';
}

async function deleteRendeles(felvetel) {
    if (!confirm('Biztosan törölni szeretnéd?')) return;

    try {
        const response = await fetch(apiUrl, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ felvetel })
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
    document.getElementById('eredetiFelvetel').value = '';
    isEditing = false;
    document.getElementById('mentesGomb').textContent = 'Mentés';
    beallitAutomatikusIdok();
}

function mutatUzenet(szoveg, szin) {
    const div = document.getElementById('uzenet');
    if (!div) return;
    div.textContent = szoveg;
    div.style.color = szin;
    setTimeout(() => {
        div.textContent = '';
    }, 3000);
}

function beallitAutomatikusIdok() {
    const now = new Date();
    const pluszKettoOra = new Date(now.getTime() + 2 * 60 * 60 * 1000);

    document.getElementById('felvetel').value = formatDateTime(now);
    document.getElementById('kiszallitas').value = formatDateTime(pluszKettoOra);
}

function formatDateTime(date) {
    const ev = date.getFullYear();
    const honap = String(date.getMonth() + 1).padStart(2, '0');
    const nap = String(date.getDate()).padStart(2, '0');
    const ora = String(date.getHours()).padStart(2, '0');
    const perc = String(date.getMinutes()).padStart(2, '0');
    const mp = String(date.getSeconds()).padStart(2, '0');
    return `${ev}-${honap}-${nap} ${ora}:${perc}:${mp}`;
}

function escapeHtml(text) {
    return String(text)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#39;');
}

function jsEscape(text) {
    return String(text)
        .replaceAll('\\', '\\\\')
        .replaceAll("'", "\\'");
}