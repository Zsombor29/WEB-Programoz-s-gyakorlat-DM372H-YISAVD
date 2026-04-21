<?php
    // Szerveroldali ellenőrzés és mentés (7. feladat)
    if(isset($_POST['uzenet'])) {
        $nev = trim($_POST['nev']);
        $email = trim($_POST['email']);
        $targy = trim($_POST['targy']);
        $uzenet = trim($_POST['uzenet']);
        $hibak = array();

        // Szerveroldali validáció (PHP)
        if(empty($nev)) $hibak[] = "A név megadása kötelező!";
        if(empty($uzenet)) $hibak[] = "Az üzenet nem lehet üres!";
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $hibak[] = "Érvénytelen e-mail cím!";

        if(empty($hibak)) {
            try {
                $dbh = new PDO('mysql:host=localhost;dbname=gyakorlat7', 'root', '',
                                array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
                $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

                $sql = "INSERT INTO uzenetek (nev, email, targy, uzenet, bejelentkezes, datum) 
                        VALUES (:nev, :email, :targy, :uzenet, :login, NOW())";
                
                $stmt = $dbh->prepare($sql);
                $login = isset($_SESSION['login']) ? $_SESSION['login'] : 'Vendég';
                
                $stmt->execute(array(
                    ':nev' => $nev,
                    ':email' => $email,
                    ':targy' => $targy,
                    ':uzenet' => $uzenet,
                    ':login' => $login
                ));
                $siker = "Köszönjük! Az üzenetet rögzítettük.";
            } catch (PDOException $e) {
                $hibak[] = "Hiba az adatbázisnál: " . $e->getMessage();
            }
        }
    }
?>

<h2>Kapcsolat</h2>

<div style="display: flex; gap: 40px; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 300px;">
        <h3>Elérhetőségeink</h3>
        <p>Ügyvezető: <strong>Sárgahegyi Tiszta Víz Kft.</strong></p>
        <p>E-mail: <strong>info@sargahegyiviz.hu</strong></p>
        
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m13!1d2726.234394985223!2d19.6669509!3d46.8960799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4743da7a6c479e1d%3A0xc8292b3f6dc69e7f!2sPallasz%20Ath%C3%A9n%C3%A9%20Egyetem%20GAMF%20Kar!5e0!3m2!1shu!2shu!4v1234567890" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>

    <div style="flex: 1; min-width: 300px;">
        <h3>Írjon nekünk!</h3>
        
        <?php if(isset($siker)) echo "<p style='color:green;'>$siker</p>"; ?>
        <?php if(!empty($hibak)) echo "<p style='color:red;'>".implode("<br>", $hibak)."</p>"; ?>
        
        <div id="js-hibak" style="color:red;"></div>

        <form id="contact-form-data" action="?oldal=kapcsolat" method="post">
            <label>Név:</label><br>
            <input type="text" id="nev" name="nev" style="width:100%"><br><br>
            
            <label>E-mail:</label><br>
            <input type="text" id="email" name="email" style="width:100%"><br><br>
            
            <label>Tárgy:</label><br>
            <input type="text" id="targy" name="targy" style="width:100%"><br><br>
            
            <label>Üzenet:</label><br>
            <textarea id="uzenet" name="uzenet" rows="5" style="width:100%"></textarea><br><br>
            
            <input type="submit" value="Üzenet küldése">
        </form>
    </div>
</div>

<script src="./scripts/uzenet.js"></script>