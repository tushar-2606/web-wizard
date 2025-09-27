<?php
require 'db.php';
$event_id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM events WHERE id=?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();
if(!$event) die("Event not found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $event['name'] ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="navbar">
  <a href="index.php">Home</a>
  <a href="admin-login.php">Admin</a>
</div>
<div class="container event-card">
    <h1><?= $event['name'] ?></h1>
    <p><?= $event['description'] ?></p>
    <p><strong>Date:</strong> <?= $event['date'] ?> | <strong>Time:</strong> <?= substr($event['time_start'],0,5) ?> - <?= substr($event['time_end'],0,5) ?></p>
    <p><strong>Location:</strong> <?= $event['location'] ?></p>

    <h2>Register</h2>
    <div id="message"></div>
    <form id="registrationForm" action="register.php" method="post">
        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
        <label>Name</label><input type="text" name="name" required>
        <label>Email</label><input type="email" name="email" required>
        <label>Phone</label><input type="text" name="phone" required>
        <button type="submit">Register</button>
    </form>
</div>
</body>
</html>
