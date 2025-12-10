<?php
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/functions.php';
require_login();
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user']['id']]);
$orders = $stmt->fetchAll();
?>
<h1 class="text-2xl font-semibold mb-4">ประวัติคำสั่งซื้อ</h1>
<?php foreach($orders as $o): ?>
  <div class="bg-white p-4 rounded shadow mb-3">
    <div class="flex justify-between"><div>เลขที่คำสั่งซื้อ: <?= $o['id'] ?></div><div><?= $o['created_at'] ?></div></div>
    <div class="mt-2 font-bold">รวม: <?= number_format($o['total_amount'],2) ?> ฿</div>
    <a href="/order_view.php?id=<?= $o['id'] ?>" class="text-sm text-blue-600 mt-2 inline-block">ดูรายละเอียด</a>
  </div>
<?php endforeach; ?>
<?php require_once __DIR__ . '/inc/footer.php'; ?>