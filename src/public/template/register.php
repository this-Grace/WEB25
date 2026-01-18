<h1 class="auth-title text-center mb-4">Crea account</h1>

<?php if ($msg = getFlashMessage('error')): ?>
    <div class="alert alert-danger"><?= $msg ?></div>
<?php endif; ?>

<?php if (!empty($registrationSuccess)): ?>
    <div class="alert alert-success">
        Registrazione completata con successo! Ora puoi effettuare il login.
    </div>
<?php endif; ?>

<?php if (empty($registrationSuccess)): ?>
    <form action="register.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

        <div class="mb-3">
            <input type="text" class="form-control" name="username" required
                placeholder="Username" value="<?= htmlspecialchars($old['username'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <input type="email" class="form-control" name="email" required
                placeholder="Email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <input type="password" class="form-control" name="password" required
                placeholder="Password" minlength="8">
        </div>

        <div class="mb-3">
            <input type="password" class="form-control" name="password_confirm" required
                placeholder="Conferma Password" minlength="8">
        </div>

        <button class="btn btn-primary w-100 mb-3">Registrati</button>
    </form>
<?php endif; ?>

<div class="text-center border-top pt-3 mt-4">
    <span class="text-muted">Hai già un account?</span>
    <a href="login.php" class="fw-semibold ms-1">Accedi</a>
</div>