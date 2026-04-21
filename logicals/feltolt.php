<?php
if (!isset($_SESSION['login'])) {
    header("Location: belepes");
    exit;
}

if (!isset($_FILES['kep'])) {
    header("Location: kepek");
    exit;
}

$file = $_FILES['kep'];

if ($file['error'] !== 0) {
    die("Feltöltési hiba kód: " . $file['error']);
}

$celMappa = realpath(__DIR__ . '/../images/upload/');
if (!$celMappa) {
    die("A célmappa nem található.");
}
$celMappa .= '/';

if (!is_writable($celMappa)) {
    die("A mappa nem írható: " . $celMappa);
}

$fajlNev = basename($file['name']);
$cel = $celMappa . $fajlNev;

$tipus = strtolower(pathinfo($cel, PATHINFO_EXTENSION));
$engedett = array('jpg','jpeg','png','gif','webp');

if (!in_array($tipus, $engedett)) {
    die("Csak képfájl tölthető fel.");
}

if (move_uploaded_file($file['tmp_name'], $cel)) {
    header("Location: kepek");
    exit;
} else {
    die("Nem sikerült a fájl mentése.");
}
?>