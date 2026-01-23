<?php

require_once __DIR__ . '/../app/bootstrap.php';

$templateParams['title'] = "Home";
$templateParams['css'] = ['assets/css/home.css'];
$templateParams['js'] = ['assets/js/filters.js', 'assets/js/load-more.js'];

$templateParams['content'] = "partials/homepage.php";

$templateParams['categories'] = $catMapper->findAll();
$templateParams['featured_events'] = $eventMapper->findAll(6, 0);

$templateParams['stats'] = [
    ['card_class' => 'stat-card stat-card-blue p-4', 'icon' => 'bi bi-calendar-event', 'value' => '28', 'label' => 'Eventi Questo Mese'],
    ['card_class' => 'stat-card stat-card-green p-4', 'icon' => 'bi bi-percent', 'value' => '89%', 'label' => 'Partecipazione Media'],
    ['card_class' => 'stat-card stat-card-orange p-4', 'icon' => 'bi bi-check-circle', 'value' => '188', 'label' => 'Eventi Completati'],
];


require 'template/base.php';
