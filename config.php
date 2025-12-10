<?php
// Database configuration - update these for your XAMPP setup
$db_host = '127.0.0.1';
$db_name = 'online_store';
$db_user = 'root';
$db_pass = ''; // default XAMPP MySQL root has empty password
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}
session_start();
define('THEME_COLOR', '#1E88E5'); // blue theme
?>