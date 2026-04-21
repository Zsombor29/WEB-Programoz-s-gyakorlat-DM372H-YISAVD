<h2>Belépés</h2>
<p>Jelentkezz be, ha szeretnél képet feltölteni vagy megtekinteni a beérkezett üzeneteket.</p>

<form action="belep" method="post">
    <fieldset>
        <legend>Belépés</legend>
        <br>
        <input type="text" name="felhasznalo" placeholder="Felhasználónév" required><br><br>
        <input type="password" name="jelszo" placeholder="Jelszó" required><br><br>
        <input type="submit" name="belepes" value="Belépés">
        <br>&nbsp;
    </fieldset>
</form>

<h3>Regisztrálj, ha még nincs fiókod!</h3>
<form action="regisztral" method="post">
    <fieldset>
        <legend>Regisztráció</legend>
        <br>
        <input type="text" name="vezeteknev" placeholder="Vezetéknév" required><br><br>
        <input type="text" name="utonev" placeholder="Utónév" required><br><br>
        <input type="text" name="felhasznalo" placeholder="Felhasználónév" required><br><br>
        <input type="password" name="jelszo" placeholder="Jelszó" required><br><br>
        <input type="submit" name="regisztracio" value="Regisztráció">
        <br>&nbsp;
    </fieldset>
</form>
