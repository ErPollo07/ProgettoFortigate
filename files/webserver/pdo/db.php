<?php
$host = "192.168.20.1"; // IP del Raspberry con MariaDB
$username = "webuser";
$password = "admin";
$db = "webuser_login_db"; // nome database

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $conn = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,            // lancia eccezioni sugli errori
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch come array associativo
        PDO::ATTR_EMULATE_PREPARES => false,                    // usa prepared statement reali (se supportato)
    ]);
} catch (PDOException $e) {
    die("Connessione fallita: " . $e->getMessage());
}
