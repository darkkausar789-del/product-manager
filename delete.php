<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi CSRF Token agar proses aman (Modul 4 - Keamanan CSRF)
    if (!hash_equals($_SESSION["csrf"] ?? "", $_POST["csrf"] ?? "")) {
        http_response_code(403);
        exit("Token CSRF tidak valid. Akses ditolak.");
    }
    
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        $stmt =$pdo->prepare("DELETE FROM products WHERE id=:id");
        $stmt->execute(['id' =>$id]);
    }
    
    header("Location: index.php?status=deleted");
    exit;
}
?>
