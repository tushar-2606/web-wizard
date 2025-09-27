<?php
session_start();
if(!isset($_SESSION['admin'])) die("Not authorized");

require 'db.php';

$id = $_GET['id'];
$action = $_GET['action'];

if ($action == "approve") {
    // check event capacity before approving
    $stmt = $pdo->prepare("SELECT event_id FROM participants WHERE id=?");
    $stmt->execute([$id]);
    $event_id = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM participants WHERE event_id=? AND status='registered'");
    $stmt->execute([$event_id]);
    $registeredCount = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT capacity FROM events WHERE id=?");
    $stmt->execute([$event_id]);
    $capacity = $stmt->fetchColumn();

    if ($registeredCount < $capacity) {
        $pdo->prepare("UPDATE participants SET status='registered' WHERE id=?")->execute([$id]);
    } else {
        echo "Event full! Cannot approve.";
        exit;
    }
}
elseif ($action == "reject") {
    $pdo->prepare("UPDATE participants SET status='rejected' WHERE id=?")->execute([$id]);
}

header("Location: admin-dashboard.php");
exit;
?>
