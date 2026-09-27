<?php
session_start();

// Generate CSRF Token
$_SESSION["csrf"] ??= bin2hex(random_bytes(32));

$host = "localhost";
$user = "root";
$pass = ""; // Sesuaikan jika ada password
$dbname = "store_db";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Fungsi untuk mencegah XSS
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, "UTF-8");
}
?>