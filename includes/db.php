<?php
function getDbConnection() {
    $host = 'localhost';
    $dbname = 'dm372h';
    $user = 'dm372h';
    $pass = 'adatbazis';
    $port = '';

    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    if ($port !== '') {
        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    }

    return new PDO($dsn, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
?>