<?php
require_once '../config/db.php';
$errors = [];

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) die("ID tidak valid");

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $id]);
$product = $stmt->fetch();
if (!$product) die("Produk tidak ditemukan");

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
            $stmt = $pdo->prepare("UPDATE products SET name=:name, category=:category, price=:price, stock=:stock WHERE id=:id");
            $stmt->execute(compact('name', 'category', 'price', 'stock', 'id'));
            header("Location: index.php?status=updated");
            exit;
        } catch (PDOException $e) {
             if ($e->getCode() == 23000) $errors['name'] = "Nama produk sudah terdaftar.";
        }
    }
}
?>
<!-- Gunakan HTML form yang persis sama seperti di create.php, tetapi ubah value input menggunakan data $product (misal: value="<?= e($_POST['name'] ?? $product['name']) ?>") -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h2>Edit Produk</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" value="<?= e($_POST['name'] ?? $product['name']) ?>" required>
                    <?php if(isset($errors['name'])) echo "<div class='error'>{$errors['name']}</div>"; ?>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="category" value="<?= e($_POST['category'] ?? $product['category']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" min="1" value="<?= e($_POST['price'] ?? $product['price']) ?>" required>
                    <?php if(isset($errors['price'])) echo "<div class='error'>{$errors['price']}</div>"; ?>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" min="0" value="<?= e($_POST['stock'] ?? $product['stock']) ?>" required>
                    <?php if(isset($errors['stock'])) echo "<div class='error'>{$errors['stock']}</div>"; ?>
                </div>
                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">Update Produk</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>