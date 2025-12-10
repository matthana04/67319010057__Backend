<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/functions.php';
$input = json_decode(file_get_contents('php://input'), true);
if($input){
    $action = $input['action'] ?? null;
    if($action === 'add'){
        cart_add($input['product_id'], $input['qty'] ?? 1);
        echo json_encode(['ok'=>1]); exit;
    }
}
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])){
    $action = $_POST['action'];
    if($action === 'add'){
        cart_add($_POST['product_id'], 1);
    } elseif($action === 'remove'){
        cart_remove($_POST['product_id']);
    }
}
header('Location: /cart.php');
?>