<?php
require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
if ($eventId <= 0) {
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
    exit;
}

$sessionEmail = $_SESSION['user']['email'] ?? '';
$event = $dbh->prepareAndExecute('SELECT u.email AS user_email FROM EVENT e LEFT JOIN USER u ON e.user_id = u.id WHERE e.id = ? LIMIT 1', [$eventId]);
if ($event && $event instanceof mysqli_result) {
    $row = $event->fetch_assoc();
    $ownerEmail = $row['user_email'] ?? '';
    if ($sessionEmail !== '' && $sessionEmail === $ownerEmail) {
        $dbh->prepareAndExecute('UPDATE EVENT SET status = ? WHERE id = ?', ['CANCELLED', $eventId]);
    }
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;
