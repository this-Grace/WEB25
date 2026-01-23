<?php
// public/api/events.php
// Returns HTML for a page of events (used by AJAX "Load more")

require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$events = $eventMapper->findAll($limit, $offset);

$html = '';
foreach ($events as $ev) {
    $img = EVENTS_IMG_DIR . htmlspecialchars($ev['image'] ?? '', ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars($ev['title'] ?? '', ENT_QUOTES, 'UTF-8');
    $loc = htmlspecialchars($ev['location'] ?? '', ENT_QUOTES, 'UTF-8');
    $rawDate = $ev['event_date'] ?? '';
    $displayDate = htmlspecialchars($rawDate, ENT_QUOTES, 'UTF-8');
    if (!empty($rawDate)) {
        $dt = DateTime::createFromFormat('Y-m-d H:i:s', $rawDate);
        if ($dt !== false) {
            $displayDate = $dt->format('d/m/Y') . ' - ' . $dt->format('H:i');
        }
    }
    $catLabel = $ev['category_label'] ?? 'Evento';
    $catClass = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $catLabel));

    $seatsText = '';
    if (isset($ev['available_seats']) && isset($ev['total_seats'])) {
        $seatsText = $ev['available_seats'] . '/' . $ev['total_seats'] . ' iscritti';
    }

    $html .= '<div class="col-lg-4 col-md-6 mb-4" data-category-id="' . htmlspecialchars($ev['category_id'] ?? '', ENT_QUOTES, 'UTF-8') . '">';
    $html .= '<div class="card event-card h-100">';
    $html .= '<div class="position-relative">';
    $html .= '<img src="' . $img . '" class="card-img-top" alt="Immagine evento: ' . $title . '">';
    $html .= '<span class="badge position-absolute top-0 start-0 m-3 badge-cate-' . htmlspecialchars($catClass, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($catLabel, ENT_QUOTES, 'UTF-8') . '</span>';
    $html .= '</div>';
    $html .= '<div class="card-body d-flex flex-column">';
    $html .= '<h3 class="card-title">' . $title . '</h3>';
    $html .= '<p class="small text-muted mb-2">' . htmlspecialchars($ev['description'] ?? '', ENT_QUOTES, 'UTF-8') . '</p>';
    $html .= '<p class="card-text text-muted small flex-grow-1">';
    $html .= '<span class="bi bi-calendar text-primary" aria-hidden="true"></span> ' . $displayDate . '<br>';
    $html .= '<span class="bi bi-geo-alt text-danger" aria-hidden="true"></span> ' . $loc . '<br>';
    $html .= '<span class="bi bi-people text-success" aria-hidden="true"></span> ' . htmlspecialchars($seatsText, ENT_QUOTES, 'UTF-8');
    $html .= '</p>';
    if (isset($_SESSION['user'])) {
        $cta = htmlspecialchars($ev['cta_href'] ?? '#', ENT_QUOTES, 'UTF-8');
        $label = htmlspecialchars($ev['cta_label'] ?? 'Iscriviti', ENT_QUOTES, 'UTF-8');
        $html .= '<a href="' . $cta . '" class="btn btn-dark w-100 mt-auto" aria-label="' . $label . '">' . $label . '</a>';
    }
    $html .= '</div></div></div>';
}

echo json_encode(['html' => $html, 'count' => count($events)]);
exit;
