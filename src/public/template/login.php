<h1 id="pageTitle" class="auth-title text-center mb-4">UniMatch</h1>

<?php if ($msg = getFlashMessage('error')): ?>
    <div class="alert alert-danger">
        <?= $msg ?>
    </div>
<?php endif; ?>

<form action="login.php" method="POST" novalidate>
    <input type="hidden" name="csrf_token"
        value="<?= htmlspecialchars($csrfToken) ?>">

    <div class="mb-3">
        <input type="email"
            class="form-control"
            name="email"
            value="<?= htmlspecialchars($old['email'] ?? '') ?>"
            placeholder="Username o Email"
            autocomplete="email"
            required>
    </div>

    <div class="mb-3">
        <input type="password"
            class="form-control"
            name="password"
            placeholder="Password"
            autocomplete="current-password"
            required>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3">
        Accedi
    </button>

    <div class="text-center mb-3">
        <a href="forgot.php" class="auth-link">Password dimenticata?</a>
    </div>
</form>

<div class="text-center border-top pt-3">
    <span class="text-muted">Non hai un account?</span>
    <a href="register.php" class="auth-link fw-semibold ms-1">Registrati</a>
</div>