<?php

require_once __DIR__ . '/../app/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$allCategories = $categoryMapper->findAll();

$templateParams['title'] = "Home";
$templateParams['css'] = 'assets/css/home.css';
$templateParams['js'] = ['assets/js/filters.js', 'assets/js/load-more.js', 'assets/js/search.js'];

$templateParams['content'] = "partials/homepage.php";

$templateParams["total_events"] = "250+";
$templateParams["active_student"] = "5000+";
$templateParams["total_hoster"] = "50+";
$templateParams["total_categories"] = count($allCategories ?? []);

$templateParams['categories'] = $allCategories;

$templateParams["event_this_month"] = $eventMapper->getEventsThisMonth();
$templateParams["avg_participation"] = (int) $eventMapper->getAvgParticipationPercent();
$templateParams["completed_events"] = $eventMapper->getCompletedEventsCount();

$templateParams['featured_events'] = $eventMapper->getApprovedOrCancelledEvents(6);

if (isset($_SESSION['user']['id'])) {
    $templateParams['user_subscriptions'] = $subscriptionMapper->findSubscribedEventsByUser(
        $_SESSION['user']['id'], 
        array_column($templateParams['featured_events'], 'id')
    );
}

require 'template/base.php';
