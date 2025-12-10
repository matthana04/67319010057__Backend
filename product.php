<?php
require_once __DIR__ . '/../inc/config.php';
require_once __DIR__ . '/../inc/functions.php';
$id = $_GET['id'] ?? null;
if(!$id){ http_response_code(400); echo json_encode(['error'=>'no id']); exit; }
$p = get_product($id);
if(!$p){ http_response_code(404); echo json_encode(['error'=>'not found']); exit; }
header('Content-Type: application/json');
echo json_encode($p);
?>