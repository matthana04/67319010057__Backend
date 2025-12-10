<?php
require_once __DIR__ . '/../inc/config.php';
require_once __DIR__ . '/../inc/functions.php';
require_role('seller');
// load seller id
$user = current_user();
$stmt = $pdo->prepare('SELECT id FROM sellers WHERE user_id = ?');
$stmt->execute([$user['id']]);
$seller = $stmt->fetch();
if(!$seller){ die('No seller record.'); }
$sid = $seller['id'];
// CRUD products basic
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action'])){
    if($_POST['action']==='create'){
        $stmt = $pdo->prepare('INSERT INTO products (seller_id,name,description,price,approved,created_at) VALUES (?,?,?,?,0,NOW())');
        $stmt->execute([$sid, $_POST['name'], $_POST['description'], $_POST['price']]);
    }
}
$products = $pdo->prepare('SELECT * FROM products WHERE seller_id = ?');
$products->execute([$sid]);
$products = $products->fetchAll();
require_once __DIR__ . '/../inc/header.php';
?>
<h1 class="text-2xl font-semibold mb-4">Seller Dashboard</h1>
<div class="bg-white p-4 rounded shadow">
  <h2 class="font-semibold">เพิ่มสินค้าใหม่ (จะรอการอนุมัติจาก Admin)</h2>
  <form method="post" class="mt-2">
    <input type="hidden" name="action" value="create">
    <input name="name" placeholder="ชื่อสินค้า" class="w-full border p-2 rounded mt-1">
    <input name="price" placeholder="ราคา" class="w-full border p-2 rounded mt-1">
    <textarea name="description" placeholder="รายละเอียด" class="w-full border p-2 rounded mt-1"></textarea>
    <div class="mt-2"><button class="px-4 py-2 rounded bg-blue-600 text-white">เพิ่ม</button></div>
  </form>
</div>
<div class="mt-4 bg-white p-4 rounded shadow">
  <h2 class="font-semibold">สินค้าของฉัน</h2>
  <?php foreach($products as $p): ?>
    <div class="border-b py-2 flex justify-between">
      <div><?= htmlspecialchars($p['name']) ?> - <?= number_format($p['price'],2) ?> ฿ (<?= $p['approved'] ? 'อนุมัติ' : 'รออนุมัติ' ?>)</div>
      <div><a href="/seller/product_edit.php?id=<?= $p['id'] ?>" class="text-sm text-blue-600">แก้ไข</a></div>
    </div>
  <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>