<?php
require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$special = isset($_GET['special']) ? trim($_GET['special']) : null;

$categories = isset($_GET['categories']) ? (array)$_GET['categories'] : null;

if (empty($categories) && isset($_GET['categoryId']) && $_GET['categoryId'] !== '') {
    $rawCategory = trim($_GET['categoryId']);
    if (strtolower($rawCategory) === 'waiting') {
        $special = 'waiting';
    } elseif (is_numeric($rawCategory)) {
        $categories = [(int)$rawCategory];
    }
}

$role = 'guest';
$userId = null;
if (!empty($_SESSION['user'])) {
    $role = strtolower($_SESSION['user']['role'] ?? 'guest');
    $userId = $_SESSION['user']['id'] ?? null;
}

$events = $eventMapper->getEventsWithFilters($role, $userId, $limit, $offset, $categories, $special, $search);

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
echo json_encode([
    'success' => true, 
    'html' => $html, 
    'count' => count($events)
]);