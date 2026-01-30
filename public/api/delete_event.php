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

$userRole = strtolower($_SESSION['user']['role'] ?? '');
$sessionEmail = $_SESSION['user']['email'] ?? '';

$eventMapper = new Event($dbh);
$evt = $eventMapper->getEventById($eventId);
if ($evt) {
    $ownerEmail = $evt['user_email'] ?? '';
    if ($userRole === 'admin' || ($sessionEmail !== '' && $sessionEmail === $ownerEmail)) {
        $eventMapper->deleteEvent($eventId);
    }
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;
