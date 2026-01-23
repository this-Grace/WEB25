<?php
session_start();

// if (!isset($_SESSION['user'])) {
//     header('Location: login.php?error=unauthorized');
//     exit;
// }

require_once __DIR__ . '/../app/bootstrap.php';

$templateParams["title"] = "Profilo";
$templateParams['css'] = ['assets/css/profile.css'];
$templateParams['js'] = ['assets/js/edit-profile.js'];

$templateParams["content"] = "partials/profile-dashboard.php";

require "template/base.php";
?>