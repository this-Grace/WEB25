<?php
require_once __DIR__ . '/../../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$userId = $_SESSION['user']['id'] ?? null;

if ($eventId > 0 && $userId) {
    $success = $eventMapper->cancel($eventId, $userId);
    
    if ($success) {
        $event = $eventMapper->getEventById($eventId);
        $html = '';

        if ($event) {
            ob_start();
            include __DIR__ . '/../partials/event-card.php';
            $html = ob_get_clean();
        }

        echo json_encode(['success' => true, 'message' => 'Evento annullato.', 'html' => $html]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Impossibile annullare l\'evento.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dati non validi o sessione scaduta.']);
}
exit;
