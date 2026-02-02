<?php
require_once __DIR__ . '/../app/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['user']['id'];
if (empty($userId)) {
    header('Location: login.php?error=not_logged_in');
    exit;
}

$templateParams["title"] = "Profilo";
$templateParams['css'] = 'assets/css/profile.css';
$templateParams['js'] = ['assets/js/edit-profile.js', 'assets/js/events-actions.js'];
$templateParams["content"] = "partials/profile-dashboard.php";

$templateParams["user"] = $userMapper->findByEmail($_SESSION['user']['email']);
$templateParams["events_subscribed"] = $eventMapper->getSubscriptionsByUserId($userId);
$templateParams["events_organized"] = $eventMapper->getEventsOrganizedByUser($userId, ['APPROVED']);
$templateParams["events_waiting"] = $eventMapper->getEventsOrganizedByUser($userId, ['WAITING']);
$templateParams["events_drafts"] = $eventMapper->getEventsOrganizedByUser($userId, ['DRAFT']);
$templateParams["events_history"] = $eventMapper->getUserEventHistory($userId);

$eventIds = array_column($templateParams["events_subscribed"], 'id');
$templateParams['user_subscriptions'] = !empty($eventIds) 
    ? $subscriptionMapper->findSubscribedEventsByUser($userId, $eventIds) 
    : [];

require "template/base.php";
