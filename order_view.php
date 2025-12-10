<?php
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/functions.php';
$id = $_GET['id'] ?? null;
if(!$id) die('No id');
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$id]);
$order = $stmt->fetch();
if(!$order) die('Order not found');
$stmt = $pdo->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON p.id = oi.product_id WHERE oi.order_id = ?");
$stmt->execute([$id]);
$items = $stmt->fetchAll();
?>
<h1 class="text-2xl font-semibold mb-4">รายละเอียดคำสั่งซื้อ #<?= $order['id'] ?></h1>
<div class="bg-white p-4 rounded shadow">
  <?php foreach($items as $it): ?>
    <div class="flex justify-between py-2 border-b">
      <div><?= htmlspecialchars($it['name']) ?> x <?= $it['qty'] ?></div>
      <div><?= number_format($it['price'] * $it['qty'],2) ?> ฿</div>
    </div>
  <?php endforeach; ?>
  <div class="mt-3 font-bold text-right">รวม <?= number_format($order['total_amount'],2) ?> ฿</div>
</div>
<?php require_once __DIR__ . '/inc/footer.php'; ?>