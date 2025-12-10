<?php
require_once __DIR__ . '/../inc/config.php';
require_once __DIR__ . '/../inc/functions.php';
require_role('admin');
// load some counts
$c1 = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$c2 = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$c3 = $pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
require_once __DIR__ . '/../inc/header.php';
?>
<h1 class="text-2xl font-semibold mb-4">Admin Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <div class="bg-white p-4 rounded shadow">ผู้ใช้ทั้งหมด: <?= $c1 ?></div>
  <div class="bg-white p-4 rounded shadow">สินค้าทั้งหมด: <?= $c2 ?></div>
  <div class="bg-white p-4 rounded shadow">คำสั่งซื้อทั้งหมด: <?= $c3 ?></div>
</div>
<div class="mt-6 bg-white p-4 rounded shadow">
  <h2 class="font-semibold">จัดการสินค้า (รออนุมัติ)</h2>
  <?php
  $stmt = $pdo->query('SELECT p.*, u.name AS seller FROM products p LEFT JOIN users u ON p.seller_id = u.id WHERE p.approved = 0');
  $pending = $stmt->fetchAll();
  foreach($pending as $p): ?>
    <div class="border-b py-2 flex justify-between items-center">
      <div><?= htmlspecialchars($p['name']) ?> (โดย <?= htmlspecialchars($p['seller']) ?>)</div>
      <div>
        <a href="/admin/product_approve.php?id=<?= $p['id'] ?>" class="px-2 py-1 bg-green-600 text-white rounded">อนุมัติ</a>
        <a href="/admin/product_delete.php?id=<?= $p['id'] ?>" class="px-2 py-1 bg-red-600 text-white rounded">ลบ</a>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>