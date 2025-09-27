<?php
session_start();

// Directly redirect to admin page after login button click
header('Location: admin.php');
exit;
?>
