<?php
session_start();
require_once __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        header('Location: login.php?error=missing');
        exit;
    }

    $user = $userMapper->authenticate($email, $password);
    if (!$user) {
        header('Location: login.php?error=invalid');
        exit;
    }

    $_SESSION['user'] = [
        'email' => $user['email'],
        'name' => $user['name'],
        'surname' => $user['surname'],
        'role' => $user['role']
    ];

    header('Location: index.php');
    exit;
}

$templateParams['title'] = "Login";
$templateParams['content'] = "partials/login-form.php";

require 'template/base.php';
