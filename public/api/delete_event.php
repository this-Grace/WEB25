<?php
require_once __DIR__ . '/../../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$userId  = $_SESSION['user']['id'] ?? null;
$userRole = strtolower($_SESSION['user']['role'] ?? '');

if ($eventId <= 0 || !$userId) {
    echo json_encode(['success' => false, 'message' => 'Dati mancanti o sessione scaduta']);
    exit;
}

$evt = $eventMapper->getEventById($eventId);
if ($evt && ($userRole === 'admin' || $userId === (int)$evt['user_id'])) {
    $ok = $eventMapper->delete($eventId);
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'Evento eliminato con successo']);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Permesso negato o errore durante l\'eliminazione']);
exit; 