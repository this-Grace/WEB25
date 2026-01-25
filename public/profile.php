<?php
session_start();
require_once __DIR__ . '/../app/bootstrap.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    header('Location: login.php?error=not_logged_in');
    exit;
}

$userId = $_SESSION['user']['id'];
$userEmail = $_SESSION['user']['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'update_profile':
            $name = trim($_POST['name']);
            $surname = trim($_POST['surname']);

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $fileName = time() . '_' . basename($_FILES['avatar']['name']);
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/../public/' . PROFILE_IMG_DIR . $fileName)) {
                    $userMapper->updateAvatar($userEmail, $fileName);
                    $_SESSION['user']['avatar'] = $fileName;
                }
            }

            if ($userMapper->updateProfile($userEmail, $name, $surname, $userEmail)) {
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['surname'] = $surname;
            }
            break;

        case 'delete_account':
            break;

        case 'unsub_event':
            break;

        case 'delete_event':
            break;
    }
}

$user = $userMapper->findByEmail($userEmail);
if (!$user) {
    header('Location: login.php?error=user_not_found');
    exit;
}

$templateParams["user"] = $user;
$templateParams["feedback_msg"] = $msg;
$templateParams["feedback_type"] = $msgType;

$templateParams["status_map"] = [
    'DRAFT'     => ['class' => 'bg-secondary', 'label' => 'Bozza'],
    'WAITING'   => ['class' => 'bg-warning text-dark', 'label' => 'In Revisione'],
    'APPROVED'  => ['class' => 'bg-success', 'label' => 'Approvato'],
    'CANCELLED' => ['class' => 'bg-danger', 'label' => 'Annullato']
];

$templateParams["tabs"] = [
    [
        'id' => 'iscritti-pane',
        'label' => 'Iscrizioni',
        // 'data' => $eventMapper->getEventsSubscribedByUser($userId),
        'active' => true
    ],
    [
        'id' => 'organizzati-pane',
        'label' => 'Miei Eventi',
        // 'data' => $eventMapper->getEventsOrganizedByUser($userId, ['APPROVED', 'WAITING']),
        'active' => false
    ],
    [
        'id' => 'bozze-pane',
        'label' => 'Bozze',
        // 'data' => $eventMapper->getEventsOrganizedByUser($userId, ['DRAFT']),
        'active' => false
    ],
    [
        'id' => 'storico-pane',
        'label' => 'Storico',
        // 'data' => $eventMapper->getUserEventHistory($userId),
        'active' => false
    ]
];

$templateParams["title"] = "Profilo";
$templateParams['css'] = ['assets/css/profile.css'];
$templateParams['js'] = ['assets/js/edit-profile.js'];

$templateParams["content"] = "partials/profile-dashboard.php";

require "template/base.php";
