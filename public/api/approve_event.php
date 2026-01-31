<?php
require_once __DIR__ . '/../../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$userRole = strtolower($_SESSION['user']['role'] ?? '');

if ($eventId <= 0 || $userRole !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Permessi insufficienti o evento non valido.']);
    exit;
}

$ok = $eventMapper->update(['status' => 'APPROVED'], $eventId);

if ($ok) {
    $event = $eventMapper->getEventById($eventId);

    ob_start();
    include __DIR__ . '/../partials/event-card.php';
    $html = ob_get_clean();

    echo json_encode([
        'success' => true, 
        'message' => 'Evento approvato con successo.',
        'html'    => $html
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore durante l\'aggiornamento dell\'evento.']);
}
exit;
