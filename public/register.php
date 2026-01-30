<?php
require_once __DIR__ . '/../app/bootstrap.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (!$first || !$last || !$email || !$password) {
        header('Location: register.php?error=missing');
        exit;
    }

    if ($password !== $confirm) {
        header('Location: register.php?error=nomatch');
        exit;
    }

    if ($userMapper->exists($email)) {
        header('Location: register.php?error=exists');
        exit;
    }

    if ($userMapper->create($email, $first, $last, $password, 'USER')) {
        header('Location: login.php?registered=1');
        exit;
    } else {
        header('Location: register.php?error=dberror');
        exit;
    }
}

$templateParams['title'] = "Register";
$templateParams['content'] = "partials/register-form.php";

require 'template/base.php';
