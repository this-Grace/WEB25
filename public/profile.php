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
    'error' => 'Si è verificato un errore durante l\'operazione.'
];
$displayMsg = $feedbackMap[$msg] ?? "";

$user = $userMapper->findByEmail($userEmail);
if (!$user) {
    header('Location: login.php?error=user_not_found');
    exit;
}

$templateParams["user"] = $user;
$templateParams["feedback_msg"] = $displayMsg;
$templateParams["feedback_type"] = $msgType;

$templateParams["status_map"] = [
    'DRAFT'     => ['class' => 'bg-secondary', 'label' => 'Bozza'],
    'WAITING'   => ['class' => 'bg-warning text-dark', 'label' => 'In Revisione'],
    'APPROVED'  => ['class' => 'bg-success', 'label' => 'Approvato'],
    'CANCELLED' => ['class' => 'bg-danger', 'label' => 'Annullato']
];

$allTabs = [
    'subscriber' => [
        'id' => 'subscriber-pane',
        'label' => 'Iscrizioni',
        'data' => $eventMapper->getEventsSubscribedByUser($userId),
        'active' => true
    ],
    'organized' => [
        'id' => 'organized-pane',
        'label' => 'Miei Eventi',
        'data' => $eventMapper->getEventsOrganizedByUser($userId, ['APPROVED', 'WAITING']),
        'active' => false
    ],
    'draft' => [
        'id' => 'draft-pane',
        'label' => 'Bozze',
        'data' => $eventMapper->getEventsOrganizedByUser($userId, ['DRAFT']),
        'active' => false
    ],
    'history' => [
        'id' => 'history-pane',
        'label' => 'Storico',
        'data' => $eventMapper->getUserEventHistory($userId),
        'active' => false
    ]
];

$activeTabs = [];

$activeTabs[] = $allTabs['subscriber'];

if (in_array(strtolower($userRole), ['host', 'admin'], true)) {
    $activeTabs[] = $allTabs['organized'];
    $activeTabs[] = $allTabs['draft'];
    $activeTabs[] = $allTabs['history'];
}

$templateParams["tabs"] = $activeTabs;

$templateParams["title"] = "Profilo";
$templateParams['css'] = ['assets/css/profile.css'];
$templateParams['js'] = ['assets/js/edit-profile.js'];
$templateParams["content"] = "partials/profile-dashboard.php";

require "template/base.php";
