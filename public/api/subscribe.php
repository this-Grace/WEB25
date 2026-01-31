<?php
require_once __DIR__ . '/../../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$userId = $_SESSION['user']['id'] ?? null;

if ($eventId > 0 && $userId) {
    $code = 'p_' . bin2hex(random_bytes(4));
    $ok = $subscriptionMapper->create($userId, $eventId, $code);

    if ($ok) {
        $event = $eventMapper->getEventById($eventId);
        
        $templateParams['user_subscriptions'] = [$eventId];

        ob_start();
        include __DIR__ . '/../partials/event-card.php';
        $html = ob_get_clean();

        echo json_encode(['success' => true, 'html' => $html]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore durante l\'iscrizione.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Sessione non valida.']);
}
exit;
