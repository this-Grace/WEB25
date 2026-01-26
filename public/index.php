<?php

require_once __DIR__ . '/../app/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$templateParams['title'] = "Home";
$templateParams['css'] = ['assets/css/home.css'];
$templateParams['js'] = ['assets/js/filters.js', 'assets/js/load-more.js', 'assets/js/search.js'];

$templateParams['content'] = "partials/homepage.php";

$allCategories = $categoryMapper->findAll();

$templateParams["total_events"] = "250+";
$templateParams["active_student"] = "5000+";
$templateParams["total_hoster"] = "50+";
$templateParams["total_categories"] = count($allCategories ?? []);

$templateParams['categories'] = $allCategories;

$templateParams["event_this_month"] = $eventMapper->getEventsThisMonth();
$templateParams["avg_participation"] = (int) $eventMapper->getAvgParticipationPercent();
$templateParams["completed_events"] = $eventMapper->getCompletedEventsCount();

$role = strtolower($_SESSION['user']['role'] ?? '');
$userEmail = $_SESSION['user']['email'] ?? null;

$roleHandlers = [
    'admin' => function () use ($eventMapper) {
        return $eventMapper->getEventsForAdmin(6);
    },
    'host' => function () use ($eventMapper, $userEmail) {
        return $userEmail ? $eventMapper->getEventsForHost($userEmail, 6) : $eventMapper->getApprovedOrCancelledEvents(6);
    },
];

if (isset($roleHandlers[$role])) {
    $templateParams['featured_events'] = $roleHandlers[$role]();
} else {
    $templateParams['featured_events'] = $eventMapper->getApprovedOrCancelledEvents(6);
}

$eventIds = array_map(function ($event) {
    return $event['id'];
}, $templateParams['featured_events']);

$templateParams['user_subscriptions'] = [];
if ($userEmail && !empty($eventIds)) {
    $templateParams['user_subscriptions'] = $subscriptionMapper->findSubscribedEventsByUser($userEmail, $eventIds);
}

require 'template/base.php';
