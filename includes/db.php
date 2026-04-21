<?php
function getDbConnection() {
    $host = 'localhost';
    $dbname = 'pizza_king_app'; // A képed alapján módosítva
    $user = 'root';             // XAMPP alapértelmezett
    $pass = '';                 // XAMPP alapértelmezett (üres)
    $port = '';

    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    
    // Ha a port üres, nem kell beleírni a DSN-be
    return new PDO($dsn, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
?>