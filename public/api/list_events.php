<?php
require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Read params
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

$categoryId = null;
$special = isset($_GET['special']) ? trim($_GET['special']) : null;

if (isset($_GET['categoryId']) && $_GET['categoryId'] !== '') {
    $rawCategory = trim($_GET['categoryId']);
    if (strtolower($rawCategory) === 'waiting') {
        $special = 'waiting';
    } elseif (is_numeric($rawCategory)) {
        $categoryId = (int)$rawCategory;
    }
}

$search = isset($_GET['search']) ? trim($_GET['search']) : null;

$role = 'guest';
$userId = null;
if (!empty($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $role = strtolower($user['role'] ?? 'guest');
    $userId = $user['id'] ?? null;
}

$events = $eventMapper->getEventsWithFilters($role, $userId, $limit, $offset, $categoryId, $special, $search);

$userSubscriptions = [];
if ($userId && !empty($events)) {
    $eventIds = array_column($events, 'id');
    $userSubscriptions = $subscriptionMapper->findSubscribedEventsByUser($userId, $eventIds);
}

$html = '';
foreach ($events as $event) {
    $e = $event;
    $templateParams['user_subscriptions'] = $userSubscriptions;
    ob_start();
    include __DIR__ . '/../partials/event-card.php';
    $html .= ob_get_clean();
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['success' => true, 'html' => $html, 'count' => count($events)]);
