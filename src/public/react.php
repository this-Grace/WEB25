<?php

/**
 * Reaction Controller
 * 
 * Handles user reactions (like/skip) to posts.
 */

session_start();
require_once __DIR__ . '/../app/functions.php';
require_once __DIR__ . '/../app/Post.php';

// Ensure user is logged in
requireLogin();

// Get user and reaction data from POST request
$user = $_SESSION['username'] ?? null;
$postId = intval($_POST['post_id'] ?? 0);
$type = $_POST['type'] ?? null;

// Validate input parameters
if (!$user || !$postId || !in_array($type, ['like', 'skip'])) {
    setFlashMessage('error', 'Invalid request parameters.');
    redirect('index.php');
}

// Process the reaction
$postModel = new Post();
$success = $postModel->react($postId, $user, $type);

if (!$success) {
    setFlashMessage('error', 'Unable to save reaction.');
    redirect('index.php');
}

// Redirect back to homepage after successful reaction
redirect('index.php');
