<?php
require_once __DIR__ . '/../../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$userId = $_SESSION['user']['id'] ?? null;

if ($eventId > 0 && $userId) {
    $sub = $subscriptionMapper->findByUserAndEvent($userId, $eventId);

    if ($sub && isset($sub['subscription_id'])) {
        $ok = $subscriptionMapper->delete((int)$sub['subscription_id']);
        
        if ($ok) {
            $event = $eventMapper->getEventById($eventId);
            $templateParams['user_subscriptions'] = [];

            ob_start();
            include __DIR__ . '/../partials/event-card.php';
            $html = ob_get_clean();

            echo json_encode(['success' => true, 'html' => $html]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore durante la disiscrizione.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Iscrizione non trovata.']);
    }
}
exit;
