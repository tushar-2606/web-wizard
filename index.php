<?php
session_start();
require 'db.php';

// Fetch all events from DB
$events = $pdo->query("SELECT * FROM events ORDER BY date ASC")->fetchAll();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Portal</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h1 class="logo">Tech Events 2025</h1>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <?php if($isLoggedIn): ?>
            <li><a href="logout.php">Logout</a></li>
            <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                <li><a href="admin.php">Admin Dashboard</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="admin-login.php">Admin Login</a></li>
        <?php endif; ?>
    </ul>
</div>

<!-- Hero Section -->
<section class="hero-sec">
    <div class="hero-top">
        <div class="hero-text">
            <h1>Welcome to Tech Events 2025</h1>
            <p>Register now for exciting workshops, talks, and competitions.</p>
        </div>
        <div class="hero-image">
            <img src="event-hero.jpg" alt="Event Image">
        </div>
    </div>
</section>

<!-- Events Section -->
<section class="highlights">
    <h2>Available Events</h2>
    <div class="card-container">
        <?php foreach($events as $event): ?>
            <div class="card">
                <h3><?= htmlspecialchars($event['name']) ?></h3>
                <ul>
                    <li><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></li>
                    <li><strong>Capacity:</strong> <?= htmlspecialchars($event['capacity']) ?> seats</li>
                </ul>
                <?php if($isLoggedIn): ?>
                    <form action="register.php" method="POST">
                        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                        <button type="submit">Register</button>
                    </form>
                <?php else: ?>
                    <a href="registration.php" class="btn">Login to Register</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Footer -->
<footer class="footer-body">
    <div class="footer-container">
        <div class="link-column">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </div>
        <div class="contact-column">
            <h4>Contact</h4>
            <p>Email: support@techevents.com</p>
            <p>Phone: +91-9876543210</p>
        </div>
        <div class="follow-column">
            <h4>Follow Us</h4>
            <p>Twitter | LinkedIn | Instagram</p>
        </div>
    </div>
    <p class="final">&copy; 2025 Tech Events. All rights reserved.</p>
</footer>

</body>
</html>
