<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../app/bootstrap.php';

if (empty($_SESSION['user']['id'])) {
    header('Location: login.php?error=not_logged_in');
    exit;
}

$userId = $_SESSION['user']['id'];
$userEmail = $_SESSION['user']['email'] ?? '';
$userRole = strtolower($_SESSION['user']['role'] ?? '');

$msg = $_GET['msg'] ?? "";
$msgType = isset($_GET['error']) ? "danger" : "success";
$feedbackMap = [
    'updated' => 'Profilo aggiornato con successo!',
    'deleted' => 'Evento rimosso correttamente.',
    'unsubscribed' => 'Iscrizione annullata.',
    'published' => 'Evento inviato per la revisione.',
    'created' => 'Evento creato correttamente.',
    'error' => 'Si è verificato un errore durante l\'operazione.'
];

$templateParams["user"] = $userMapper->findByEmail($userEmail);
if (!$templateParams["user"]) {
    header('Location: login.php?error=user_not_found');
    exit;
}

$templateParams["feedback_msg"] = $feedbackMap[$msg] ?? "";
$templateParams["feedback_type"] = $msgType;
$templateParams["user_role"] = $userRole;

$templateParams["events_subscribed"] = $eventMapper->getEventsSubscribedByUser($userId);
$templateParams["events_organized"] = $eventMapper->getEventsOrganizedByUser($userId, ['APPROVED', 'WAITING']);
$templateParams["events_drafts"] = $eventMapper->getEventsOrganizedByUser($userId, ['DRAFT']);
$templateParams["events_history"] = $eventMapper->getUserEventHistory($userId);

$templateParams["status_map"] = [
    'DRAFT'     => ['class' => 'bg-secondary', 'label' => 'Bozza'],
    'WAITING'   => ['class' => 'bg-warning text-dark', 'label' => 'In Revisione'],
    'APPROVED'  => ['class' => 'bg-success', 'label' => 'Approvato'],
    'CANCELLED' => ['class' => 'bg-danger', 'label' => 'Annullato']
];

$templateParams["title"] = "Profilo";
$templateParams['css'] = ['assets/css/profile.css'];
$templateParams['js'] = ['assets/js/edit-profile.js'];
$templateParams["content"] = "partials/profile-dashboard.php";

require "template/base.php";
