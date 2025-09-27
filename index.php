<?php
require 'db.php';
$events = $pdo->query("SELECT * FROM events ORDER BY date ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Event Portal</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="navbar">
  <a href="index.php">Home</a>
  <a href="admin-login.php">Admin</a>
</div>
<div class="container">
    <h1>Upcoming Events</h1>
    <div class="events-grid">
        <?php foreach($events as $event):
            $stmt = $pdo->prepare("SELECT COUNT(*) as cnt FROM participants WHERE event_id=? AND status='registered'");
            $stmt->execute([$event['id']]);
            $registered = $stmt->fetch()['cnt'];
            $spots_left = $event['max_capacity'] - $registered;
            $progress = round(($registered/$event['max_capacity'])*100);
        ?>
        <div class="event-card">
            <h2><?= $event['name'] ?></h2>
            <p><?= substr($event['description'],0,100) ?>...</p>
            <p><strong>Date:</strong> <?= $event['date'] ?> | <strong>Time:</strong> <?= substr($event['time_start'],0,5) ?> - <?= substr($event['time_end'],0,5) ?></p>
            <p><strong>Location:</strong> <?= $event['location'] ?></p>
            <p><?= $registered ?>/<?= $event['max_capacity'] ?> registered</p>
            <div class="progress-bar">
                <div class="progress" style="width: <?= $progress ?>%;"></div>
            </div>
            <?php if($spots_left>0): ?>
            <a href="event.php?id=<?= $event['id'] ?>" class="btn btn-primary">Register Now</a>
            <?php else: ?>
            <span class="status-waiting">Full - Join Waiting List</span>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
