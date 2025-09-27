<?php
session_start();
require 'db.php';

// If already logged in, go to dashboard
if (isset($_SESSION['admin'])) {
    header("Location: admin-dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch admin user from DB
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        // Correct login → start session
        $_SESSION['admin'] = $admin['username'];
        header("Location: admin-dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="assets/css/styles.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family:"Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to bottom right, #fbfcfd, #EAF6FA);
    }

    .login-container {
      max-width: 400px;
      margin: 80px auto;
      padding: 30px;
      border-radius: 12px;
      background: linear-gradient(135deg, #e9f4fb, #fcfeff);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .login-container h2 {
      text-align: center;
      color: #011f40;
      margin-bottom: 20px;
    }

    .login-container form {
      display: flex;
      flex-direction: column;
    }

    .login-container label {
      font-weight: bold;
      margin-bottom: 5px;
      color: #0a2a4d;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 15px;
      font-size: 16px;
    }

    .login-container button {
      background-color:#011f40;
      color:#fff;
      padding: 12px;
      font-size: 17px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    .login-container button:hover {
      background-color: #4682B4;
    }

    .error {
      color: red;
      text-align: center;
      margin-bottom: 15px;
    }

  </style>
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>

      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
