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
$code = 'p_' . bin2hex(random_bytes(6));
$ok = $subscriptionMapper->create($email, $eventId, $code);

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));

exit;
