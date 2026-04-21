<?php
$eredmeny_uzenet = "";
$eredmeny_hiba = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev = trim($_POST['nev'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $targy = trim($_POST['targy'] ?? '');
    $uzenet = trim($_POST['uzenet'] ?? '');

    if ($nev === '') {
        $nev = isset($_SESSION['login']) ? ($_SESSION['csn'] . ' ' . $_SESSION['un'] . ' (' . $_SESSION['login'] . ')') : 'Vendég';
    }

    if ($email === '' || $targy === '' || $uzenet === '' || $nev === '') {
        $eredmeny_hiba = true;
        $eredmeny_uzenet = "Kérjük, tölts ki minden mezőt.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $eredmeny_hiba = true;
        $eredmeny_uzenet = "Adj meg egy érvényes e-mail címet.";
    } else {
        try {
            include('./includes/db.php');
            $dbh = getDbConnection();

            $sqlInsert = "INSERT INTO uzenetek (nev, email, targy, uzenet) VALUES (:nev, :email, :targy, :uzenet)";
            $stmt = $dbh->prepare($sqlInsert);
            $stmt->execute(array(
                ':nev' => $nev,
                ':email' => $email,
                ':targy' => $targy,
                ':uzenet' => $uzenet
            ));

            $eredmeny_uzenet = "Üzenetedet sikeresen elküldtük.";
            $eredmeny_hiba = false;
        } catch (PDOException $e) {
            $eredmeny_hiba = true;
            $eredmeny_uzenet = "Adatbázis hiba: " . $e->getMessage();
        }
    }
}
?>