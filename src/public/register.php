<?php

/**
 * User Registration Controller
 *
 * Handles user registration process including validation,
 * CSRF protection, and user creation in database.
 */

session_start();

require_once __DIR__ . '/../app/User.php';
require_once __DIR__ . '/../app/helpers.php';

$pageTitle = 'Registrati';
$ariaLabel = 'Area di registrazione';

// Generate CSRF token
$csrfToken = generateCsrfToken();

// Get old form values from session
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

// Check if registration was successful
$registrationSuccess = false;
if (!empty($_SESSION['registration_success'])) {
    $registrationSuccess = true;
    unset($_SESSION['registration_success']);
}

// Process POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get and sanitize form data
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['password_confirm'] ?? '';

    // Store values for form repopulation
    $_SESSION['old'] = [
        'username' => $username,
        'email'    => $email
    ];

    // Validate CSRF token
    if (!isValidCsrf($_POST['csrf_token'] ?? null)) {
        setFlashMessage('error', 'Richiesta non valida');
        redirect('register.php');
    }

    $errors = [];

    // Validate required fields
    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = 'Tutti i campi sono obbligatori';
    }

    // Validate email format
    if (!isValidEmail($email)) {
        $errors[] = 'Formato email non valido';
    }

    // Validate password strength
    if (!isValidPassword($password)) {
        $errors[] = 'La password deve essere di almeno 8 caratteri';
    }

    // Confirm password match
    if ($password !== $confirm) {
        $errors[] = 'Le password non coincidono';
    }

    // Validate username format
    if (!empty($username) && !isValidUsernameFormat($username)) {
        $errors[] = 'Username può contenere solo lettere, numeri e underscore';
    }

    // Validate username length
    if (!empty($username) && strlen($username) < 3) {
        $errors[] = 'Username deve essere di almeno 3 caratteri';
    }

    // Check database if basic validation passes
    if (empty($errors)) {
        $user = new User();

        // Check if username exists
        if ($user->usernameExists($username)) {
            $errors[] = 'Username già in uso';
        }

        // Check if email exists
        if ($user->emailExists($email)) {
            $errors[] = 'Email già registrata';
        }

        // Attempt to create user
        if (empty($errors) && !$user->create($username, $email, $password, '', '', '')) {
            $errors[] = 'Errore durante la registrazione. Riprova.';
        }
    }

    // Handle validation results
    if (!empty($errors)) {
        // Store errors and redirect (PRG pattern)
        setFlashMessage('error', formatErrors($errors));
        redirect('register.php');
    } else {
        // Clear session data and flag success
        unset($_SESSION['csrf_token']);
        unset($_SESSION['old']);
        $_SESSION['registration_success'] = true;
        redirect('register.php');
    }
}

// Render template
ob_start();
include 'template/register.php';
$content = ob_get_clean();
include 'template/auth.php';
