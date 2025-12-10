<?php
require_once __DIR__ . '/../inc/config.php';
require_once __DIR__ . '/../inc/functions.php';
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email = $_POST['email']; $pwd = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]); $u = $stmt->fetch();
    if($u && password_verify($pwd, $u['password'])){
        // login success
        $_SESSION['user'] = ['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];
        header('Location: /index.php'); exit;
    } else $err = 'ข้อมูลผิดพลาด';
}
require_once __DIR__ . '/../inc/header.php';
?>
<h1 class="text-2xl font-semibold mb-4">เข้าสู่ระบบ</h1>
<?php if($err) echo '<div class="text-red-600">'.htmlspecialchars($err).'</div>'; ?>
<form method="post" class="bg-white p-4 rounded shadow max-w-md">
  <label class="block">อีเมล <input name="email" required class="w-full mt-1 p-2 border rounded"></label>
  <label class="block mt-2">รหัสผ่าน <input type="password" name="password" required class="w-full mt-1 p-2 border rounded"></label>
  <div class="mt-4"><button class="px-4 py-2 rounded bg-blue-600 text-white">เข้าสู่ระบบ</button></div>
</form>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>