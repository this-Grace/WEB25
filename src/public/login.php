<?php

/**
 * Login Controller
 * 
 * Handles user authentication process.
 * Verifies credentials, manages CSRF tokens, and redirects
 * user after successful login.
 */

session_start();

require_once __DIR__ . '/../app/User.php';
require_once __DIR__ . '/../app/functions.php';

$pageTitle = 'Login';
$ariaLabel = 'Area di accesso';

$csrfToken = generateCsrfToken();
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $_SESSION['old'] = ['email' => $login];

    // CSRF check
    if (!isValidCsrf($_POST['csrf_token'] ?? null)) {
        setFlashMessage('error', 'Richiesta non valida');
        redirect('login.php');
    }

    $errors = [];

    // Required fields
    if (empty($login) || empty($password)) {
        $errors[] = 'Tutti i campi sono obbligatori';
    }

    if (empty($errors)) {
        $userModel = new User();

        $user = $userModel->checkLogin($login, $password);

        if (!$user) {
            $errors[] = 'Credenziali non valide';
        }
    }

    // Handle errors
    if (!empty($errors)) {
        setFlashMessage('error', formatErrors($errors));
        redirect('login.php');
    }

    // Login success: store user info in session
    unset($_SESSION['csrf_token'], $_SESSION['old']);

    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = $user['role'];

    redirect('index.php');
}

// Render view
ob_start();
include 'template/login.php';
$content = ob_get_clean();
include 'template/auth.php';
