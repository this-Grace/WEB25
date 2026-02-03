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

$templateParams['title'] = 'Crea Evento';
$templateParams['css'] = 'assets/css/create-event.css';
$templateParams['js'] = ['assets/js/drag-and-drop.js', 'assets/js/event-preview.js'];
$templateParams['content'] = 'partials/event-form.php';

$templateParams['categories'] = $categoryMapper->findAll();

$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
if ($eventId > 0) {
    $row = $eventMapper->getEventById($eventId);
    if (strtolower($row['status']) === 'approved') {
        header("Location: profile.php?error=already_approved");
        exit;
    }
    if (!empty($row)) {
        $templateParams['h1'] = 'Modifica Evento';
        $templateParams['form_action'] = 'api/edit_event.php?event_id=' . $eventId;
        $templateParams['event'] = $row;
    } else {
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }
} else {
    $templateParams['h1'] = 'Crea Nuovo Evento';
    $templateParams['form_action'] = 'api/create_event.php';
}

require 'template/base.php';
