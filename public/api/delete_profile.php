<?php
require_once __DIR__ . '/../../app/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user']['email'])) {
    $userEmail = $_SESSION['user']['email'];
    
    if ($userMapper->delete($userEmail)) {
        session_destroy();
        header('Location: ../index.php?msg=account_deleted');
        exit;
    }
}

header('Location: ../profile.php?error=1&msg=error');
exit;