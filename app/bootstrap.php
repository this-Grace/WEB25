<?php

/**
 * Configuration and Initialization
 *
 * This file initializes the database connection and creates a User instance.
 * It should be included in other PHP files that need database access.
 */
require_once __DIR__ . '/database.php';

require_once __DIR__ . '/orm/Category.php';
require_once __DIR__ . '/orm/Event.php';
require_once __DIR__ . '/orm/User.php';
require_once __DIR__ . '/orm/Subscription.php';

define("EVENTS_IMG_DIR", "upload/img/events/");
define("PROFILE_IMG_DIR", "upload/img/profile/");

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASSWORD') ?: '';
$dbName = getenv('DB_NAME') ?: 'web25';
$dbPort = getenv('DB_PORT') ? intval(getenv('DB_PORT')) : 3306;
$dbCharset = getenv('DB_CHARSET') ?: 'utf8mb4';

$dbh = new DatabaseHelper($dbHost, $dbUser, $dbPass, $dbName, $dbPort, $dbCharset);

$userMapper = new User($dbh);
$eventMapper = new Event($dbh);
$categoryMapper = new Category($dbh);
$subscriptionMapper = new Subscription($dbh);
