<?php
require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
if ($eventId <= 0 || empty($_SESSION['user']['email'])) {
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
    exit;
}

$email = $_SESSION['user']['email'];
$sub = $subscriptionMapper->findByUserAndEvent($email, $eventId);
if ($sub && !empty($sub['subscription_id'])) {
    $subscriptionMapper->delete((int)$sub['subscription_id']);
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;
