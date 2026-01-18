<?php

/**
 * Home Controller
 * 
 * Displays the main home page with user information and next available post.
 * Handles post recommendations and user session management.
 */

session_start();
require_once __DIR__ . '/../app/functions.php';
require_once __DIR__ . '/../app/User.php';
require_once __DIR__ . '/../app/Post.php';

// Ensure user is logged in
requireLogin();

// Get current user information
$user = new User()->find($_SESSION['username']);

// Get next recommended post for the user
$post = new Post()->nextPost($user['username']);

// Page metadata
$pageTitle = "Home";
$ariaLabel = "Home page";

// Render view
ob_start();
include 'partials/post.php';
$content = ob_get_clean();
include 'template/base.php';
