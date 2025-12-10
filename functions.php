<?php
require_once __DIR__ . '/config.php';

function sanitize($s){ return htmlspecialchars(trim($s)); }

function is_logged_in(){
    return !empty($_SESSION['user']);
}
function current_user(){
    return $_SESSION['user'] ?? null;
}
function require_login(){
    if(!is_logged_in()){
        header('Location: /auth/login.php'); exit;
    }
}
function has_role($role){
    $u = current_user();
    return $u && $u['role'] === $role;
}
function require_role($role){
    if(!is_logged_in() || !has_role($role)){
        header('Location: /auth/login.php'); exit;
    }
}

function get_products($onlyApproved=true){
    global $pdo;
    $sql = "SELECT p.*, s.name AS seller_name FROM products p LEFT JOIN sellers s ON p.seller_id = s.id";
    if($onlyApproved) $sql .= " WHERE p.approved = 1";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function get_product($id){
    global $pdo;
    $stmt = $pdo->prepare("SELECT p.*, s.name AS seller_name FROM products p LEFT JOIN sellers s ON p.seller_id = s.id WHERE p.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Cart stored in session
function cart_add($product_id, $qty=1){
    if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if(isset($_SESSION['cart'][$product_id])) $_SESSION['cart'][$product_id] += $qty;
    else $_SESSION['cart'][$product_id] = $qty;
}
function cart_remove($product_id){
    if(isset($_SESSION['cart'][$product_id])) unset($_SESSION['cart'][$product_id]);
}
function cart_items(){
    return $_SESSION['cart'] ?? [];
}
function cart_clear(){ unset($_SESSION['cart']); }

?>