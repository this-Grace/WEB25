<?php
$navColorClass = "bg-danger"; // Red for admin

$menuItems = [
    ['label' => 'Dashboard', 'link' => 'admin.php', 'active' => true],
    ['label' => 'Utenti', 'link' => 'admin-users.html'],
    ['label' => 'Post', 'link' => 'admin-posts.html'],
    ['label' => 'Segnalazioni', 'link' => 'admin-reports.html'],
];

require "base.php";