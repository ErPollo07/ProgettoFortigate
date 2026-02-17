<?php

$host = "192.168.1.207"; // IP del Raspberry con MariaDB
$username = "webuser";
$password = "admin";
$db = "login_db"; // nome database

$conn = new mysqli($host, $username, $password, $db);

//$conn = new PDO(
//    "mysql:host=$host;dbname=$db;charset=utf8mb4",
//    $username,
//    $password
//);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
