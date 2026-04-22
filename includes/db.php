<?php
function getDbConnection() {
    $host = 'localhost';
    $dbname = 'dm372h'; 
    $user = 'dm372h';          
    $pass = 'adatbazis';                
    $port = '';

    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    
    // Ha a port üres, nem kell beleírni a DSN-be
    return new PDO($dsn, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
?>