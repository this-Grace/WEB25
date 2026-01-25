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
if ($userRole !== 'admin') {
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
    exit;
}
$ok = $dbh->prepareAndExecute('UPDATE EVENT SET status = ? WHERE id = ?', ['APPROVED', $eventId]);
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));

exit;
