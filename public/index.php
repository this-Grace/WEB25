<?php

require_once __DIR__ . '/../app/bootstrap.php';

$templateParams['title'] = "Home";
$templateParams['css'] = ['assets/css/home.css'];
$templateParams['js'] = ['assets/js/filters.js', 'assets/js/load-more.js', 'assets/js/homepage-search.js'];

$templateParams['content'] = "partials/homepage.php";
$templateParams['categories'] = $catMapper->findAll();
$templateParams['featured_events'] = $eventMapper->findAll(6, 0);

require 'template/base.php';
