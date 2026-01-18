<?php

session_start();

require_once __DIR__ . '/../app/User.php';
require_once __DIR__ . '/../app/functions.php';

$pageTitle = 'Registrati';
$ariaLabel = 'Area di registrazione';

$csrfToken = generateCsrfToken();
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

$registrationSuccess = !empty($_SESSION['registration_success']);
unset($_SESSION['registration_success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['password_confirm'] ?? '';

    $_SESSION['old'] = ['username' => $username, 'email' => $email];

    if (!isValidCsrf($_POST['csrf_token'] ?? null)) {
        setFlashMessage('error', 'Richiesta non valida');
        redirect('register.php');
    }

    $errors = [];

    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = 'Tutti i campi sono obbligatori';
    } elseif (!isValidEmail($email)) {
        $errors[] = 'Formato email non valido';
    } elseif (!isValidPassword($password)) {
        $errors[] = 'La password deve essere di almeno 8 caratteri';
    } elseif ($password !== $confirm) {
        $errors[] = 'Le password non coincidono';
    } elseif (!isValidUsernameFormat($username) || strlen($username) < 3) {
        $errors[] = 'Username: 3+ caratteri (lettere, numeri, underscore)';
    } else {
        $user = new User();
        if ($user->usernameExists($username)) {
            $errors[] = 'Username già in uso';
        } elseif ($user->emailExists($email)) {
            $errors[] = 'Email già registrata';
        } elseif (!$user->create($username, $email, $password, '', '', '')) {
            $errors[] = 'Errore durante la registrazione. Riprova.';
        }
    }

    if (!empty($errors)) {
        setFlashMessage('error', formatErrors($errors));
        redirect('register.php');
    } else {
        unset($_SESSION['csrf_token'], $_SESSION['old']);
        $_SESSION['registration_success'] = true;
        redirect('login.php');
    }
}

ob_start();
?>

<h1 class="auth-title text-center mb-4">Crea account</h1>

<?php if ($msg = getFlashMessage('error')): ?>
    <div class="alert alert-danger"><?= $msg ?></div>
<?php endif; ?>

<?php if (!$registrationSuccess): ?>
    <form action="register.php" method="POST" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

        <div class="mb-3">
            <input type="text" class="form-control" name="username"
                placeholder="Username" value="<?= htmlspecialchars($old['username'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <input type="email" class="form-control" name="email"
                placeholder="Email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <input type="password" class="form-control" name="password"
                placeholder="Password" minlength="8" required>
        </div>

        <div class="mb-3">
            <input type="password" class="form-control" name="password_confirm"
                placeholder="Conferma Password" minlength="8" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">Registrati</button>
    </form>
<?php endif; ?>

<div class="text-center border-top pt-3">
    <span class="text-muted">Hai già un account?</span>
    <a href="login.php" class="auth-link fw-semibold ms-1">Accedi</a>
</div>

<?php
$content = ob_get_clean();
include 'template/auth.php';
