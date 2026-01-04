<?php
$pageTitle = 'Recupera password';
$ariaLabel = 'Area recupero password';

$content = <<<'HTML'
<h1 id="pageTitle" class="auth-title text-center mb-4">Recupera password</h1>
<form action="forgot.php" method="POST" novalidate>
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
    <div class="mb-3">
        <input type="email" class="form-control" id="forgotEmail" name="email" required
            autocomplete="email" placeholder="Email">
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3"
        aria-label="Invia istruzioni di reset">Invia</button>

    <div class="text-center mb-3">
        <a href="login.php" class="auth-link" aria-label="Torna al login">Torna al login</a>
    </div>
</form>

<div class="text-center border-top pt-3" aria-label="Vai alla registrazione">
    <span class="text-muted">Non hai un account?</span>
    <a href="register.php" class="auth-link fw-semibold ms-1">Registrati</a>
</div>
HTML;

include 'template/auth.php';
