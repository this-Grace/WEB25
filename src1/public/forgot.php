<?php

session_start();

require_once __DIR__ . '/../app/functions.php';

$pageTitle = 'Recupera password';

$csrfToken = generateCsrfToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!isValidCsrf($_POST['csrf_token'] ?? null)) {
        setFlashMessage('error', 'Richiesta non valida');
        redirect('forgot.php');
    }

    if (empty($email)) {
        setFlashMessage('error', 'Email obbligatoria');
        redirect('forgot.php');
    }

    // TODO: Implementare logica di reset password
    $_SESSION['reset_sent'] = true;
    redirect('forgot.php');
}

$resetSent = !empty($_SESSION['reset_sent']);
unset($_SESSION['reset_sent']);

ob_start();
?>

<h1 class="auth-title text-center mb-4">Recupera password</h1>

<?php if ($msg = getFlashMessage('error')): ?>
    <div class="alert alert-danger"><?= $msg ?></div>
<?php endif; ?>

<?php if ($resetSent): ?>
    <div class="alert alert-success mb-4">
        Istruzioni di reset inviate alla tua email.
    </div>
<?php endif; ?>

<form action="forgot.php" method="POST" novalidate>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

    <div class="mb-3">
        <input type="email" class="form-control" name="email"
            placeholder="Email" autocomplete="email" required>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3">Invia</button>

    <div class="text-center mb-3">
        <a href="login.php" class="auth-link">Torna al login</a>
    </div>
</form>

<div class="text-center border-top pt-3">
    <span class="text-muted">Non hai un account?</span>
    <a href="register.php" class="auth-link fw-semibold ms-1">Registrati</a>
</div>

<?php
$content = ob_get_clean();
include 'template/auth.php';
