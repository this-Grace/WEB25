<?php
require_once __DIR__ . '/../app/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$role = trim(strtolower((string)($_SESSION['user']['role'] ?? '')));
if ($role === '' || !in_array($role, ['admin', 'host'], true)) {
    header('Location: index.php');
    exit;
}

$templateParams['css'] = ['assets/css/create-event.css'];
$templateParams['js'] = ['assets/js/drag-and-drop.js', 'assets/js/event-preview.js'];
$templateParams['content'] = 'partials/event-form.php';

$templateParams['categories'] = $categoryMapper->findAll();

$templateParams['title'] = 'Crea Evento';

$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
if ($eventId > 0) {
    $sql = "SELECT e.*, u.email AS user_email, c.id AS category_id, c.name AS category FROM EVENT e LEFT JOIN USER u ON e.user_id = u.id LEFT JOIN CATEGORY c ON e.category_id = c.id WHERE e.id = ? LIMIT 1";
    $res = $dbh->prepareAndExecute($sql, [$eventId]);
    if ($res && $res instanceof mysqli_result) {
        $row = $res->fetch_assoc();
        $ownerEmail = $row['user_email'] ?? '';
        $sessionEmail = $_SESSION['user']['email'] ?? '';

        if ($role === 'admin' || ($sessionEmail !== '' && $sessionEmail === $ownerEmail)) {
            $templateParams['event'] = $row;
            $templateParams['h1'] = 'Modifica Evento';
            $templateParams['is_edit'] = true;
            $templateParams['form_action'] = 'api/edit_event.php?event_id=' . $eventId;
        } else {
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
            exit;
        }
    } else {
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }
} else {
    $templateParams['h1'] = 'Crea Nuovo Evento';
    $templateParams['is_edit'] = false;
    $templateParams['form_action'] = 'api/create_event.php';
}

require 'template/base.php';
