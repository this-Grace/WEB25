<?php
require_once __DIR__ . '/../../app/bootstrap.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $userEmail = $_SESSION['user']['email'];
    
    if ($userMapper->delete($userEmail)) {
        session_destroy();
        header('Location: ../index.php?msg=account_deleted');
        exit;
    }
}

header('Location: ../profile.php?error=1&msg=error');
exit;