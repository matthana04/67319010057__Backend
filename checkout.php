<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/functions.php';
if(!is_logged_in()){
    header('Location: /auth/login.php'); exit;
}
$items = cart_items();
if(!$items){ header('Location: /cart.php'); exit; }
// load product details
$ids = implode(',', array_map('intval', array_keys($items)));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
$products = $stmt->fetchAll();
$total = 0;
foreach($products as $p) $total += $p['price'] * $items[$p['id']];
// create order
$pdo->beginTransaction();
try{
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$_SESSION['user']['id'], $total]);
    $order_id = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, qty, price) VALUES (?, ?, ?, ?)");
    foreach($products as $p){
        $qty = $items[$p['id']];
        $stmt->execute([$order_id, $p['id'], $qty, $p['price']]);
    }
    $pdo->commit();
    cart_clear();
    header('Location: /orders.php'); exit;
}catch(Exception $e){
    $pdo->rollBack();
    die('Checkout failed: '.$e->getMessage());
}
?>