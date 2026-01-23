<?php

/**
 * Configuration and Initialization
 * 
 * This file initializes the database connection and creates a User instance.
 * It should be included in other PHP files that need database access.
 */
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/orm/User.php';
require_once __DIR__ . '/orm/Category.php';

$dbh = new DatabaseHelper("localhost", "root", "", "web25", 3306, 'utf8mb4');

$userMapper = new User($dbh->getConnection());
$catMapper = new Category($dbh->getConnection());
