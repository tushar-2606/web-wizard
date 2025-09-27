<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: admin-login.php");

require 'db.php';
$participants = $pdo->query("SELECT p.name, p.email, p.phone, p.status, e.name as event_name 
                             FROM participants p
                             JOIN events e ON p.event_id = e.id
                             ORDER BY e.id, p.status")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="navbar">
  <a href="index.php">Home</a>
  <a href="logout.php">Logout</a>
</div>
<div class="container">
    <h1>Admin Dashboard</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Event</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($participants as $p): ?>
        <tr>
            <td><?= $p['event_name'] ?></td>
            <td><?= $p['name'] ?></td>
            <td><?= $p['email'] ?></td>
            <td><?= $p['phone'] ?></td>
            <td class="status-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
