<?php
require_once __DIR__ . '/../inc/config.php';
require_once __DIR__ . '/../inc/functions.php';
require_role('seller');
$id = $_GET['id'] ?? null;
if(!$id) die('No id');
$stmt = $pdo->prepare('SELECT p.* FROM products p JOIN sellers s ON p.seller_id = s.id WHERE p.id = ? AND s.user_id = ?');
$stmt->execute([$id, $_SESSION['user']['id']]);
$p = $stmt->fetch();
if(!$p) die('Not authorized');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $stmt = $pdo->prepare('UPDATE products SET name=?, description=?, price=? WHERE id=?');
    $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], $id]);
    header('Location: /seller/dashboard.php'); exit;
}
require_once __DIR__ . '/../inc/header.php';
?>
<h1 class="text-2xl font-semibold mb-4">แก้ไขสินค้า</h1>
<form method="post" class="bg-white p-4 rounded shadow max-w-md">
  <input name="name" value="<?= htmlspecialchars($p['name']) ?>" class="w-full border p-2 rounded mt-1">
  <input name="price" value="<?= htmlspecialchars($p['price']) ?>" class="w-full border p-2 rounded mt-1">
  <textarea name="description" class="w-full border p-2 rounded mt-1"><?= htmlspecialchars($p['description']) ?></textarea>
  <div class="mt-2"><button class="px-4 py-2 rounded bg-blue-600 text-white">บันทึก</button></div>
</form>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>