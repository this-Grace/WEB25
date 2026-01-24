<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || !in_array(strtolower($_SESSION['user']['role']), ['admin', 'host'], true)) {
    header('Location: index.php');
    exit;
}

$templateParams['title'] = "Crea Evento";
$templateParams['css'] = ['assets/css/create-event.css'];
$templateParams['js'] = ['assets/js/drag-and-drop.js', 'assets/js/event-preview.js'];

$templateParams['content'] = "partials/add-event.php";

require 'template/base.php';
