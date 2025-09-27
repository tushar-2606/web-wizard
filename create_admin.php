<?php
require 'db.php';

$hash = password_hash("ps", PASSWORD_DEFAULT);
$pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)")
    ->execute(["adminAS", $hash]);
echo "Admin created!";
