<?php
require 'db.php';

$event_id = $_POST['event_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Check how many already registered
$stmt = $pdo->prepare("SELECT COUNT(*) FROM participants WHERE event_id=? AND status='registered'");
$stmt->execute([$event_id]);
$registeredCount = $stmt->fetchColumn();

// Get event capacity
$stmt = $pdo->prepare("SELECT capacity FROM events WHERE id=?");
$stmt->execute([$event_id]);
$capacity = $stmt->fetchColumn();

$status = ($registeredCount < $capacity) ? "registered" : "waiting";

$stmt = $pdo->prepare("INSERT INTO participants (event_id,name,email,phone,status) VALUES (?,?,?,?,?)");
$stmt->execute([$event_id, $name, $email, $phone, $status]);

echo "<p>Thank you for registering! Your status: <b>$status</b></p>";
echo "<a href='index.php'>Back</a>";
?>
