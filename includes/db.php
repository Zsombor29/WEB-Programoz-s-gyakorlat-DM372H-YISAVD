<?php
function getDbConnection() {
    $host = 'localhost';
    $dbname = 'pizza_king_app';
    $user = 'root';
    $pass = '';
    $port = '';

    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    if ($port !== '') {
        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    }

    return new PDO($dsn, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
?>