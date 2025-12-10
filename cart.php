<?php
require_once __DIR__ . '/inc/header.php';
$items = cart_items();
$products = [];
if($items){
    $ids = implode(',', array_map('intval', array_keys($items)));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$total=0;
?>
<h1 class="text-2xl font-semibold mb-4">ตะกร้าสินค้า</h1>
<?php if(!$items): ?>
  <div class="bg-white p-4 rounded shadow">ตะกร้าว่าง</div>
<?php else: ?>
  <div class="bg-white p-4 rounded shadow">
    <form method="post" action="/checkout.php">
      <table class="w-full">
        <?php foreach($products as $p): $qty = $items[$p['id']]; $subtotal = $p['price'] * $qty; $total += $subtotal; ?>
        <tr class="border-b">
          <td class="py-2"><?php echo htmlspecialchars($p['name']); ?></td>
          <td class="py-2">x <?php echo $qty; ?></td>
          <td class="py-2 text-right"><?php echo number_format($subtotal,2); ?> ฿</td>
        </tr>
        <?php endforeach; ?>
      </table>
      <div class="mt-4 text-right font-bold">รวม: <?php echo number_format($total,2); ?> ฿</div>
      <div class="mt-4 text-right">
        <button class="px-4 py-2 rounded bg-blue-600 text-white">สั่งซื้อ (Checkout)</button>
      </div>
    </form>
  </div>
<?php endif; ?>
<?php require_once __DIR__ . '/inc/footer.php'; ?>