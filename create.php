<?php
require_once '../config/db.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

    if (mb_strlen($name) < 3) $errors['name'] = "Nama minimal 3 karakter.";
    if ($price === false || $price <= 0) $errors['price'] = "Harga harus > 0.";
    if ($stock === false || $stock < 0) $errors['stock'] = "Stok tidak boleh negatif.";

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, category, price, stock) VALUES (:name, :category, :price, :stock)");
            $stmt->execute(['name' => $name, 'category' => $category, 'price' => $price, 'stock' => $stock]);
            header("Location: index.php?status=created");
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) $errors['name'] = "Nama produk sudah terdaftar (harus unik).";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h2>Tambah Produk Baru</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" value="<?= e($_POST['name'] ?? '') ?>" required>
                    <?php if(isset($errors['name'])) echo "<div class='error'>{$errors['name']}</div>"; ?>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="category" value="<?= e($_POST['category'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" min="1" value="<?= e($_POST['price'] ?? '') ?>" required>
                    <?php if(isset($errors['price'])) echo "<div class='error'>{$errors['price']}</div>"; ?>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" min="0" value="<?= e($_POST['stock'] ?? '') ?>" required>
                    <?php if(isset($errors['stock'])) echo "<div class='error'>{$errors['stock']}</div>"; ?>
                </div>
                
                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
