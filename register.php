<!DOCTYPE html>
<html>
<head>
    <title>Registration Confirmation</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="navbar">
  <a href="index.php">Home</a>
  <a href="admin-login.php">Admin</a>
</div>

<div class="container">
    <?php if($status=='registered'): ?>
        <div class="status-registered" style="padding:20px; font-size:1.2rem; text-align:center; margin-bottom:20px;">
            🎉 Congratulations, <?= htmlspecialchars($name) ?>! Your registration for <strong><?= htmlspecialchars($event['name']) ?></strong> is successful.
        </div>
        <p style="text-align:center; font-size:1rem; color:#444;">
            We are excited to have you join us. Here are the event details:
        </p>
        <ul style="max-width:500px; margin: 0 auto 30px auto; font-size:1rem; line-height:1.6;">
            <li><strong>Event Name:</strong> <?= htmlspecialchars($event['name']) ?></li>
            <li><strong>Date:</strong> <?= $event['date'] ?></li>
            <li><strong>Time:</strong> <?= substr($event['time_start'],0,5) ?> - <?= substr($event['time_end'],0,5) ?></li>
            <li><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></li>
            <li><strong>Registered Email:</strong> <?= htmlspecialchars($email) ?></li>
        </ul>
        <p style="text-align:center; font-size:1rem; color:#222;">
            You will receive a confirmation email shortly with further instructions. Please keep this page for reference.
        </p>
        <div style="text-align:center; margin-top:30px;">
            <a href="index.php" class="btn btn-primary">Back to Events</a>
        </div>

    <?php else: ?>
        <div class="status-waiting" style="padding:20px; font-size:1.2rem; text-align:center; margin-bottom:20px;">
            ⚠️ Hello <?= htmlspecialchars($name) ?>, the event <strong><?= htmlspecialchars($event['name']) ?></strong> is currently full.
        </div>
        <p style="text-align:center; font-size:1rem; color:#444;">
            You have been added to the waiting list. If a spot becomes available, we will notify you via email.
        </p>
        <ul style="max-width:500px; margin: 0 auto 30px auto; font-size:1rem; line-height:1.6;">
            <li><strong>Event Name:</strong> <?= htmlspecialchars($event['name']) ?></li>
            <li><strong>Date:</strong> <?= $event['date'] ?></li>
            <li><strong>Time:</strong> <?= substr($event['time_start'],0,5) ?> - <?= substr($event['time_end'],0,5) ?></li>
            <li><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></li>
            <li><strong>Registered Email:</strong> <?= htmlspecialchars($email) ?></li>
        </ul>
        <p style="text-align:center; font-size:1rem; color:#222;">
            We appreciate your interest and will notify you if a spot becomes available.
        </p>
        <div style="text-align:center; margin-top:30px;">
            <a href="index.php" class="btn btn-primary">Back to Events</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
