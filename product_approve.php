<?php
require_once __DIR__ . '/../inc/config.php';
require_once __DIR__ . '/../inc/functions.php';
require_role('admin');
$id = $_GET['id'] ?? null;
if($id){
    $stmt = $pdo->prepare('UPDATE products SET approved=1 WHERE id = ?');
    $stmt->execute([$id]);
}
header('Location: /admin/dashboard.php');
?>