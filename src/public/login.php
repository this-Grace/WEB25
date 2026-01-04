<?php
$pageTitle = 'Login';
$ariaLabel = 'Area di accesso';

$content = <<<'HTML'
<h1 id="pageTitle" class="auth-title text-center mb-4">UniMatch</h1>
<form action="index.php" method="POST" novalidate>
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
    <div class="mb-3">
        <input type="email" class="form-control" id="email" name="email" required
            autocomplete="email" placeholder="Email">
    </div>

    <div class="mb-3">
        <input type="password" class="form-control" id="password" name="password" required
            autocomplete="current-password" placeholder="Password">
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3"
        aria-label="Accedi a UniMatch">Accedi</button>

    <div class="text-center mb-3">
        <a href="forgot.php" class="auth-link" aria-label="Recupera la password">Password
            dimenticata?</a>
    </div>
</form>

<div class="text-center border-top pt-3" aria-label="Registrazione">
    <span class="text-muted">Non hai un account?</span>
    <a href="register.php" class="auth-link fw-semibold ms-1">Registrati</a>
</div>
HTML;

include 'template/auth.php';
