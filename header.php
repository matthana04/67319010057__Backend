<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
$u = current_user();
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>ร้านค้าออนไลน์ (Blue Theme)</title>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600;700&display=swap" rel="stylesheet">
  <!-- Tailwind CDN for quick setup -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: 'Kanit', sans-serif; }
    :root { --primary: <?php echo THEME_COLOR; ?>; }
  </style>
</head>
<body class="bg-slate-50 min-h-screen">
<header class="bg-white shadow-sm">
  <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
    <a href="/index.php" class="text-xl font-semibold" style="color:var(--primary)">ร้านค้าออนไลน์</a>
    <nav class="flex items-center space-x-4">
      <a href="/index.php" class="text-sm">หน้าแรก</a>
      <a href="/cart.php" class="text-sm">ตะกร้า (<?php echo array_sum(cart_items()) ?: 0; ?>)</a>
      <?php if(!$u): ?>
        <a href="/auth/login.php" class="text-sm">เข้าสู่ระบบ</a>
        <a href="/auth/register.php" class="text-sm">สมัครสมาชิก</a>
      <?php else: ?>
        <?php if($u['role']==='seller'): ?>
          <a href="/seller/dashboard.php" class="text-sm">Seller Dashboard</a>
        <?php endif; ?>
        <?php if($u['role']==='admin'): ?>
          <a href="/admin/dashboard.php" class="text-sm">Admin Dashboard</a>
        <?php endif; ?>
        <span class="text-sm">สวัสดี, <?php echo htmlspecialchars($u['name']); ?></span>
        <a href="/auth/logout.php" class="text-sm">ออกจากระบบ</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="max-w-6xl mx-auto p-4">