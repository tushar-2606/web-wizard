<?php
require 'db.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];

    // Prevent duplicate registration
    $check = $pdo->prepare("SELECT id FROM participants WHERE email = ? AND event_id = ?");
    $check->execute([$email, $event_id]);

    if ($check->rowCount() > 0) {
        $msg = "⚠️ You have already registered for this event!";
    } else {
        // Capacity check
        $stmt = $pdo->prepare("SELECT capacity FROM events WHERE id=?");
        $stmt->execute([$event_id]);
        $event = $stmt->fetch();

        $count = $pdo->prepare("SELECT COUNT(*) FROM participants WHERE event_id=? AND status='registered'");
        $count->execute([$event_id]);
        $registered_count = $count->fetchColumn();

        $status = ($registered_count < $event['capacity']) ? 'registered' : 'waiting';

        $stmt = $pdo->prepare("INSERT INTO participants (event_id, name, email, phone, status) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$event_id, $name, $email, $phone, $status]);

        $msg = "✅ Registration successful! You are <b>$status</b>.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Event Registration</title>
    <style>
        body { font-family: Inter, sans-serif; background:#eef3fb; display:flex; justify-content:center; align-items:center; height:100vh; }
        form { background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); width:350px; }
        input, select { width:100%; padding:10px; margin:10px 0; border-radius:8px; border:1px solid #ccc; }
        button { width:100%; padding:12px; background:#667eea; color:#fff; border:none; border-radius:8px; font-weight:bold; cursor:pointer; transition:0.3s; }
        button:hover { background:#764ba2; }
        .msg { margin:10px 0; padding:10px; border-radius:8px; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Register for Event</h2>

        <?php if($msg): ?>
            <div class="msg"><?= $msg ?></div>
        <?php endif; ?>

        <label>Event</label>
        <select name="event_id" required>
            <?php
            $events = $pdo->query("SELECT * FROM events")->fetchAll();
            foreach($events as $e){
                echo "<option value='{$e['id']}'>{$e['name']} (Capacity: {$e['capacity']})</option>";
            }
            ?>
        </select>

        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
