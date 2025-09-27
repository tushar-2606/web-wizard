<?php
// create_admin.php — run once from CLI or the browser then delete it
$conn = new mysqli('localhost', 'root', '', 'event_portal');
if ($conn->connect_error) die("DB error");

$username = 'admin';
$email = 'ad@example.com';
$passwordPlain = 'admin23';
$role = 'admin';

$hashed = password_hash($passwordPlain, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $hashed, $role);
if ($stmt->execute()) {
    echo "Admin created.";
} else {
    echo "Error: " . $conn->error;
}
$stmt->close();
$conn->close();
?>
