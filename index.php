<?php
require_once __DIR__ . '/inc/header.php';
$products = get_products(true);
?>
<h1 class="text-2xl font-semibold mb-4">สินค้าทั้งหมด</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
<?php foreach($products as $p): ?>
  <div class="bg-white rounded p-4 shadow">
    <img src="/assets/images/placeholder.png" alt="" class="w-full h-48 object-cover rounded">
    <h3 class="mt-2 font-semibold"><?php echo htmlspecialchars($p['name']); ?></h3>
    <p class="mt-1 text-sm text-slate-600"><?php echo htmlspecialchars($p['seller_name'] ?: 'ร้านทั่วไป'); ?></p>
    <div class="mt-2 flex items-center justify-between">
      <div class="font-bold"><?php echo number_format($p['price'],2); ?> ฿</div>
      <div class="flex space-x-2">
        <button onclick="openQuickView(<?php echo $p['id']; ?>)" class="px-3 py-1 rounded border text-sm">ดูเร็ว</button>
        <form method="post" action="/cart_action.php">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
          <button class="px-3 py-1 rounded bg-blue-600 text-white text-sm">ใส่ตะกร้า</button>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/inc/footer.php'; ?>