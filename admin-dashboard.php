<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: admin-login.php");
require 'db.php';

// Fetch participants
$sql = "SELECT p.*, e.name as event_name, e.capacity 
        FROM participants p
        JOIN events e ON p.event_id=e.id
        ORDER BY e.id, p.status";
$participants = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<div class="navbar">
    <a href="admin-dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
</div>
<div class="container">
    <h1>Admin Dashboard</h1>
    <table>
        <thead>
            <tr>
                <th>Event</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($participants as $p): ?>
            <tr>
                <td><?= $p['event_name'] ?> (Cap: <?= $p['capacity'] ?>)</td>
                <td><?= $p['name'] ?></td>
                <td><?= $p['email'] ?></td>
                <td><?= $p['phone'] ?></td>
                <td><?= ucfirst($p['status']) ?></td>
                <td>
                    <?php if($p['status']=='waiting'): ?>
                        <a href="approve.php?id=<?= $p['id'] ?>&action=approve">Approve</a>
                    <?php endif; ?>
                    <?php if($p['status']!='rejected'): ?>
                        <a href="approve.php?id=<?= $p['id'] ?>&action=reject">Reject</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
