<?php
require_once __DIR__ . '/../inc/config.php';
require_once __DIR__ . '/../inc/functions.php';
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = sanitize($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $pwd = $_POST['password'];
    $role = in_array($_POST['role'], ['user','seller']) ? $_POST['role'] : 'user';
    if(!$email) $err='อีเมลไม่ถูกต้อง';
    if(!$err){
        // create user
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name,email,password,role,created_at) VALUES (?,?,?,?,NOW())");
        $stmt->execute([$name,$email,$hash,$role]);
        // if seller, create a seller record
        if($role === 'seller'){
            $user_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare("INSERT INTO sellers (user_id, name, created_at) VALUES (?,?,NOW())");
            $stmt->execute([$user_id, $name.''s shop']);
        }
        header('Location: /auth/login.php'); exit;
    }
}
require_once __DIR__ . '/../inc/header.php';
?>
<h1 class="text-2xl font-semibold mb-4">สมัครสมาชิก</h1>
<?php if($err) echo '<div class="text-red-600">'.htmlspecialchars($err).'</div>'; ?>
<form method="post" class="bg-white p-4 rounded shadow max-w-md">
  <label class="block">ชื่อ <input name="name" required class="w-full mt-1 p-2 border rounded"></label>
  <label class="block mt-2">อีเมล <input name="email" required class="w-full mt-1 p-2 border rounded"></label>
  <label class="block mt-2">รหัสผ่าน <input type="password" name="password" required class="w-full mt-1 p-2 border rounded"></label>
  <label class="block mt-2">ประเภทผู้ใช้
    <select name="role" class="w-full mt-1 p-2 border rounded">
      <option value="user">ผู้ใช้ทั่วไป</option>
      <option value="seller">ผู้ขาย</option>
    </select>
  </label>
  <div class="mt-4"><button class="px-4 py-2 rounded bg-blue-600 text-white">สมัคร</button></div>
</form>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>