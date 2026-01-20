<?php

/**
 * Handle sending chat messages via AJAX
 */

session_start();
require_once __DIR__ . '/../app/Message.php';

header('Content-Type: application/json');

// Check authentication
$me = $_SESSION['username'] ?? null;
if (!$me) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

// Get POST data
$conversation_id = isset($_POST['conversation_id']) ? (int)$_POST['conversation_id'] : null;
$message_text = trim($_POST['message'] ?? '');

// Validate input
if (!$conversation_id || !$message_text) {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit;
}

// Create message
$messageModel = new Message();
$messageId = $messageModel->create($conversation_id, $me, $message_text);

if ($messageId) {
    // Get the newly created message
    $msg = $messageModel->find($messageId);

    // Return JSON with message data
    echo json_encode([
        'success' => true,
        'message' => $msg
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Save error']);
}
