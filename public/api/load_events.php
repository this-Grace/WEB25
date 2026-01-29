<?php
require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$offset = max(0, (int)($_GET['offset'] ?? 0));
$limit = max(1, min(50, (int)($_GET['limit'] ?? 6)));
$category = isset($_GET['category_id']) && $_GET['category_id'] !== '' ? (int)$_GET['category_id'] : null;
$filters = isset($_GET['filters']) ? trim((string)$_GET['filters']) : '';
$search = isset($_GET['q']) ? trim((string)$_GET['q']) : null;

$role = strtolower($_SESSION['user']['role'] ?? '');
$userEmail = $_SESSION['user']['email'] ?? null;

$specialFilter = null;
if ($filters !== '') {
    $parts = array_filter(array_map('trim', explode(',', $filters)));
    foreach ($parts as $p) {
        if ($p === 'waiting') {
            $specialFilter = 'waiting';
            break;
        }
        if (filter_var($p, FILTER_VALIDATE_EMAIL)) {
            $specialFilter = 'miei';
            break;
        }
    }
}

$events = $eventMapper->getEventsWithFilters($role, $userEmail, $limit, $offset, $category, $specialFilter, $search);

$html = '';
foreach ($events as $event) {
    $templateParams = $templateParams ?? [];
    $userRole = strtolower($_SESSION['user']['role'] ?? '');
    ob_start();
    include __DIR__ . '/../partials/event-grid-item.php';
    $html .= ob_get_clean();
}

header('Content-Type: application/json');
echo json_encode(['html' => $html, 'count' => count($events)]);
