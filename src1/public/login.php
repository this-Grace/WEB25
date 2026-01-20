<?php

session_start();

require_once __DIR__ . '/../app/User.php';
require_once __DIR__ . '/../app/functions.php';

$pageTitle = 'Login';
$ariaLabel = 'Area di accesso';

$csrfToken = generateCsrfToken();
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

$registrationSuccess = !empty($_SESSION['registration_success']);
unset($_SESSION['registration_success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $_SESSION['old'] = ['email' => $login];

    if (!isValidCsrf($_POST['csrf_token'] ?? null)) {
        setFlashMessage('error', 'Richiesta non valida');
        redirect('login.php');
    }

    $errors = [];

    if (empty($login) || empty($password)) {
        $errors[] = 'Tutti i campi sono obbligatori';
    } else {
        $userModel = new User();
        $user = $userModel->checkLogin($login, $password);

        if (!$user) {
            $errors[] = 'Credenziali non valide';
        }
    }

    if (!empty($errors)) {
        setFlashMessage('error', formatErrors($errors));
        redirect('login.php');
    }

    unset($_SESSION['csrf_token'], $_SESSION['old']);
    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = $user['role'];

    redirect('index.php');
}

// Render
ob_start();
?>

<h1 class="auth-title text-center mb-4">UniMatch</h1>

<?php if ($registrationSuccess): ?>
    <div class="alert alert-success">
        Registrazione completata! Accedi con le tue credenziali.
    </div>
<?php endif; ?>

<?php if ($msg = getFlashMessage('error')): ?>
    <div class="alert alert-danger"><?= $msg ?></div>
<?php endif; ?>

<form action="login.php" method="POST" novalidate>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

    <div class="mb-3">
        <input type="email" class="form-control" name="email"
            value="<?= htmlspecialchars($old['email'] ?? '') ?>"
            placeholder="Email" autocomplete="email" required>
    </div>

    <div class="mb-3">
        <input type="password" class="form-control" name="password"
            placeholder="Password" autocomplete="current-password" required>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3">Accedi</button>

    <div class="text-center mb-3">
        <a href="forgot.php" class="auth-link">Password dimenticata?</a>
    </div>
</form>

<div class="text-center border-top pt-3">
    <span class="text-muted">Non hai un account?</span>
    <a href="register.php" class="auth-link fw-semibold ms-1">Registrati</a>
</div>

<?php
$content = ob_get_clean();
include 'template/auth.php';
