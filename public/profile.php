<?php
session_start();

$templateParams["title"] = "Profilo";
$templateParams['css'] = ['assets/css/profile.css'];
$templateParams['js'] = ['assets/js/edit-profile.js'];

$templateParams["content"] = "partials/profile-dashboard.php";

require "template/base.php";
?>