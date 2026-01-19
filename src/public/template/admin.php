<?php
session_start();

// Controlla se l'utente è loggato
if (empty($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Controlla se l'utente è admin
require_once __DIR__ . '/../../app/Admin.php';
$adminModel = new Admin();
if (!$adminModel->isAdmin($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$menuItems = $menuItems ?? [
    ['label' => 'Utenti', 'url' => 'admin-users.php'],
    ['label' => 'Post', 'url' => 'admin-posts.php'],
    ['label' => 'Segnalazioni', 'url' => 'admin-reports.php'],
    ['label' => 'Esci', 'url' => 'logout.php'],
];
$navbarColor = 'danger';
$brandUrl = "admin-dashboard.php";
$requireLogin = $requireLogin ?? true;

$adminContent = $content;
$content = <<<HTML
<main class="flex-grow-1 d-flex align-items-center py-5" role="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                $adminContent
            </div>
        </div>
    </div>
</main>
HTML;

include 'base.php';
