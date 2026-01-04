<?php
$pageTitle = 'Registrati';
$ariaLabel = 'Area di registrazione';

$content = <<<'HTML'
<h1 id="pageTitle" class="auth-title text-center mb-4">Crea account</h1>
<form action="register.php" method="POST" novalidate>
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
    <div class="mb-3">
        <input type="text" class="form-control" id="regName" name="name" required
            autocomplete="name" placeholder="Nome">
    </div>
    <div class="mb-3">
        <input type="email" class="form-control" id="regEmail" name="email" required
            autocomplete="email" placeholder="Email">
    </div>
    <div class="mb-3">
        <input type="password" class="form-control" id="regPassword" name="password" required
            autocomplete="new-password" placeholder="Password">
    </div>
    <div class="mb-3">
        <input type="password" class="form-control" id="regConfirm" name="password_confirm"
            required autocomplete="new-password" placeholder="Conferma password">
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3"
        aria-label="Registrati su UniMatch">Registrati</button>
</form>

<div class="text-center border-top pt-3" aria-label="Vai al login">
    <span class="text-muted">Hai già un account?</span>
    <a href="login.php" class="auth-link fw-semibold ms-1">Accedi</a>
</div>
HTML;

include 'template/auth.php';
