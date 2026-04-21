<?php
if (isset($_POST['felhasznalo']) && isset($_POST['jelszo'])) {
    try {
        include('./includes/db.php');
        $dbh = getDbConnection();
        $sqlSelect = "SELECT id, csaladi_nev, uto_nev FROM felhasznalok WHERE bejelentkezes = :bejelentkezes AND jelszo = SHA1(:jelszo)";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':bejelentkezes' => $_POST['felhasznalo'], ':jelszo' => $_POST['jelszo']));
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $_SESSION['csn'] = $row['csaladi_nev'];
            $_SESSION['un'] = $row['uto_nev'];
            $_SESSION['login'] = $_POST['felhasznalo'];
        }
    } catch (PDOException $e) {
        $errormessage = "Hiba: " . $e->getMessage();
    }
} else {
    header("Location: .");
}
?>