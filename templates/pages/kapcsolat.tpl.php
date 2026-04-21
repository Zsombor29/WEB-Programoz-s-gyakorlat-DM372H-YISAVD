<h1 style="margin-top: 0;">Kapcsolat</h1>
<p>Ha kérdésed van a rendelésekkel, nyitvatartással vagy kínálattal kapcsolatban, írj nekünk.</p>

<div class="contact-grid">
    <div class="contact-box">
        <h2>Elérhetőségeink</h2>
        <ul class="contact-list">
            <li><strong>Cégnév:</strong> Pizza King</li>
            <li><strong>Cím:</strong> 6000 Kecskemét, Izsáki út 10.</li>
            <li><strong>Telefon:</strong> +36 30 123 4567</li>
            <li><strong>E-mail:</strong> info@pizzaking.hu</li>
            <li><strong>Nyitvatartás:</strong> H-V: 10:00 - 22:00</li>
        </ul>
    </div>

    <div class="contact-box">
        <h2>Írj nekünk</h2>

        <?php if (isset($eredmeny_uzenet) && $eredmeny_uzenet != ""): ?>
            <div class="result-box <?= $eredmeny_hiba ? 'error' : 'success' ?>">
                <?= $eredmeny_uzenet ?>
            </div>
        <?php endif; ?>

        <form id="contact-form-data" method="POST">
            <div id="js-hibak" class="js-errors"></div>

            <label for="nev">Név:</label><br>
            <input type="text" id="nev" name="nev" placeholder="Kovács János"><br>

            <label for="email">E-mail cím:</label><br>
            <input type="text" id="email" name="email" placeholder="pelda@email.hu"><br>

            <label for="targy">Tárgy:</label><br>
            <input type="text" id="targy" name="targy" placeholder="Rendelés, kérdés vagy visszajelzés"><br>

            <label for="uzenet">Üzenet:</label><br>
            <textarea id="uzenet" name="uzenet" rows="6" placeholder="Ide írhatod az üzenetedet..."></textarea><br>

            <button type="submit">Üzenet küldése</button>
        </form>
    </div>
</div>
