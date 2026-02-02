<?php

require_once __DIR__ . '/../app/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$allCategories = $categoryMapper->findAll();
$userId = $_SESSION['user']['id'] ?? null;
$userRole = isset($_SESSION['user']['role']) ? strtolower($_SESSION['user']['role']) : 'guest';

$templateParams['title'] = "Home";
$templateParams['css'] = 'assets/css/home.css';
$templateParams['js'] = ['assets/js/filters.js', 'assets/js/load-more.js', 'assets/js/search.js', 'assets/js/events-actions.js'];

$templateParams['content'] = "partials/homepage.php";

$stats = $eventMapper->getStats();
$templateParams["event_this_month"] = $stats['monthly_count'] ?? 0;
$templateParams["avg_participation"] = (int) ($stats['avg_participation'] ?? 0);
$templateParams["completed_events"] = $stats['completed_count'] ?? 0;

$templateParams["total_events"] = "250+";
$templateParams["active_student"] = "5000+";
$templateParams["total_hoster"] = "50+";
$templateParams["total_categories"] = count($allCategories ?? []);
$templateParams['categories'] = $allCategories;

$templateParams['featured_events'] = $eventMapper->getEventsWithFilters(
    role: $userRole,
    currentUserId: $userId,
    limit: 6
);

if ($userId) {
    $featuredIds = array_column($templateParams['featured_events'], 'id');
    $templateParams['user_subscriptions'] = !empty($featuredIds)
        ? $subscriptionMapper->findSubscribedEventsByUser($userId, $featuredIds)
        : [];
}

require 'template/base.php';
