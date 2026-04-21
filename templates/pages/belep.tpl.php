<?php if(isset($row)) { ?>
    <?php if($row) { ?>
        <h1>Sikeres bejelentkezés</h1>
        <p>Üdvözlünk újra a Pizza King oldalán.</p>
        <p>Azonosító: <strong><?= $row['id'] ?></strong></p>
        <p>Név: <strong><?= $row['csaladi_nev'] . " " . $row['uto_nev'] ?></strong></p>
    <?php } else { ?>
        <h1>A bejelentkezés nem sikerült</h1>
        <a href="belepes">Próbáld újra!</a>
    <?php } ?>
<?php } ?>

<?php if(isset($errormessage)) { ?>
    <h2><?= $errormessage ?></h2>
<?php } ?>
