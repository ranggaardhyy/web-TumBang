<?php
$host = 'localhost'; // Host database
$dbname = 'tumBangDB'; // Nama database
$username = 'root'; // Username database
$password = ''; // Password database

try {
    // Koneksi ke database menggunakan PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>