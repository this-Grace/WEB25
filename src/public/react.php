<?php

/**
 * Reaction Controller
 * 
 * Handles user reactions (like/skip) to posts and returns next post.
 */

session_start();
require_once __DIR__ . '/../app/functions.php';
require_once __DIR__ . '/../app/Post.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit;
}

$user   = $_SESSION['username'];
$postId = intval($_POST['post_id'] ?? 0);
$type   = strtolower(trim($_POST['type'] ?? ''));

if (!$postId || !in_array($type, ['like', 'skip'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid request parameters']);
    exit;
}

$postModel = new Post();
$success = $postModel->react($postId, $user, $type);

if (!$success) {
    echo json_encode(['success' => false, 'error' => 'Unable to save reaction']);
    exit;
}

$nextPost = $postModel->nextPost($user);

echo json_encode([
    'success' => true,
    'next_post' => $nextPost,
    'reaction' => $type
]);
exit;
