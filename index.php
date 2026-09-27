<?php
require_once '../config/db.php';


$q = trim($_GET["q"] ?? "");
if ($q !== "") {
    $sql = "SELECT * FROM products WHERE name LIKE :q1 OR category LIKE :q2 ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["q1" => "%$q%", "q2" => "%$q%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
}
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_GET['status'])): ?>
            <div class="alert">Operasi berhasil dilakukan!</div>
        <?php endif; ?>

        <header>
            <h2>Manajemen Produk</h2>
            <div class="search-form">
                <form method="GET">
                    <input type="text" name="q" placeholder="Cari nama atau kategori..." value="<?= e($q) ?>">
                    <button type="submit" class="btn btn-secondary">Cari</button>
                </form>
                <a href="create.php" class="btn btn-primary">+ Tambah Produk</a>
            </div>
        </header>

        <div class="products-grid">
            <?php if(empty($products)): ?>
                <p>Belum ada produk atau pencarian tidak ditemukan.</p>
            <?php endif; ?>
            
            <?php foreach ($products as $p): ?>
                <div class="card">
                    <h3><?= e($p['name']) ?></h3>
                    <p>Kategori: <strong><?= e($p['category']) ?></strong></p>
                    <p class="price">Rp <?= number_format($p['price'], 0, ',', '.') ?></p>
                    <p>Sisa Stok: <?= (int)$p['stock'] ?></p>
                    
                    <div class="card-actions">
                        <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-secondary" style="flex:1; text-align:center;">Edit</a>
                        <form method="POST" action="delete.php" style="flex:1; display:flex;" onsubmit="return confirm('Yakin hapus produk ini?');">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                            <button type="submit" class="btn btn-danger" style="width:100%;">Hapus</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
