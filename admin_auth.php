<?php
session_start();
require 'db.php';

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if($user && password_verify($password, $user['passwordHash'])){
    $_SESSION['admin'] = $user['username'];
    header("Location: admin.php");
    exit;
} else {
    $error = "Invalid username or password";
    header("Location: admin-login.php?error=" . urlencode($error));
    exit;
}
