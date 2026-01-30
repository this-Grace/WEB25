<?php
require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Read params
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$categoryId = isset($_GET['categoryId']) && $_GET['categoryId'] !== '' ? (int)$_GET['categoryId'] : null;
$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$special = isset($_GET['special']) ? trim($_GET['special']) : null;

$role = 'other';
$userEmail = null;
if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $role = $user['role'] ?? 'other';
    $userEmail = $user['email'] ?? null;
}

$events = $eventMapper->getEventsWithFilters($role, $userEmail, $limit, $offset, $categoryId, $special, $search);

$html = '';
foreach ($events as $event) {
    // render each event using the existing partial
    $e = $event; // provide variable name expected by event-card
    ob_start();
    include __DIR__ . '/../partials/event-card.php';
    $html .= ob_get_clean();
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['success' => true, 'html' => $html, 'count' => count($events)]);
