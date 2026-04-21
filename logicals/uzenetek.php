<?php
if (!isset($_SESSION['login'])) {
    header("Location: .");
    exit;
}

$uzenetek = array();
try {
    include('./includes/db.php');
    $dbh = getDbConnection();
    $sqlSelect = "SELECT nev, email, targy, uzenet, datum FROM uzenetek ORDER BY datum DESC";
    $sth = $dbh->prepare($sqlSelect);
    $sth->execute();
    $uzenetek = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $hibauzenet = "Hiba az üzenetek lekérésekor: " . $e->getMessage();
}
?>