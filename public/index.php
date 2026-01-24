<?php

require_once __DIR__ . '/../app/bootstrap.php';

$templateParams['title'] = "Home";
$templateParams['css'] = ['assets/css/home.css'];
$templateParams['js'] = ['assets/js/filters.js', 'assets/js/load-more.js', 'assets/js/homepage-search.js'];

$templateParams['content'] = "partials/homepage.php";

$allCategories = $catMapper->findAll();

$templateParams["total_events"] = "250+";
$templateParams["active_student"] = "5000+";
$templateParams["total_hoster"] = "50+";
$templateParams["total_categories"] = count($allCategories ?? []);

$templateParams['categories'] = $allCategories;

$templateParams["event_this_month"] = $eventMapper->getEventsThisMonth();
$templateParams["avg_participation"] = (int) $eventMapper->getAvgParticipationPercent();
$templateParams["completed_events"] = $eventMapper->getCompletedEventsCount();

require 'template/base.php';
