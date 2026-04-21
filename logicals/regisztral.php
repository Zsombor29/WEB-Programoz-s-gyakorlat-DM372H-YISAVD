<?php
if (isset($_POST['felhasznalo']) && isset($_POST['jelszo']) && isset($_POST['vezeteknev']) && isset($_POST['utonev'])) {
    try {
        include('./includes/db.php');
        $dbh = getDbConnection();

        $sqlSelect = "SELECT id FROM felhasznalok WHERE bejelentkezes = :bejelentkezes";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':bejelentkezes' => $_POST['felhasznalo']));

        if ($sth->fetch(PDO::FETCH_ASSOC)) {
            $uzenet = "A felhasználónév már foglalt.";
            $ujra = true;
        } else {
            $sqlInsert = "INSERT INTO felhasznalok(id, csaladi_nev, uto_nev, bejelentkezes, jelszo)
                          VALUES (0, :csaladinev, :utonev, :bejelentkezes, :jelszo)";
            $stmt = $dbh->prepare($sqlInsert);
            $stmt->execute(array(
                ':csaladinev' => $_POST['vezeteknev'],
                ':utonev' => $_POST['utonev'],
                ':bejelentkezes' => $_POST['felhasznalo'],
                ':jelszo' => sha1($_POST['jelszo'])
            ));

            if ($stmt->rowCount()) {
                $newid = $dbh->lastInsertId();
                $uzenet = "A regisztráció sikeres. Azonosító: {$newid}";
                $ujra = false;
            } else {
                $uzenet = "A regisztráció nem sikerült.";
                $ujra = true;
            }
        }
    } catch (PDOException $e) {
        $uzenet = "Hiba: " . $e->getMessage();
        $ujra = true;
    }
} else {
    header("Location: .");
}
?>