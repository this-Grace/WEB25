<?php
session_start();

// Se già loggato, redirect alla home
if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO: Implementare la logica di login
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Placeholder per la validazione
    if (empty($email) || empty($password)) {
        $error = 'Inserisci email e password';
    }
}

$templateParams['pageTitle'] = 'Accedi';

ob_start();
?>

<div class="text-center mb-4">
    <span class="bi bi-heart-fill text-primary" style="font-size: 3rem;" aria-hidden="true"></span>
    <h1 class="h3 mt-3 fw-bold">Benvenuto su UniMatch</h1>
    <p class="text-muted">Accedi per connetterti con altri studenti</p>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger" role="alert">
        <span class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></span><?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<form method="POST" action="/login.php">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
            <span class="input-group-text"><span class="bi bi-envelope" aria-hidden="true"></span></span>
            <input type="email" class="form-control" id="email" name="email" placeholder="tua.email@università.it" required autofocus>
        </div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><span class="bi bi-lock" aria-hidden="true"></span></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
        </div>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Ricordami</label>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">
            <span class="bi bi-box-arrow-in-right me-2" aria-hidden="true"></span>Accedi
        </button>
    </div>
</form>

<div class="text-center mt-4">
    <a href="/forgot-password.php" class="text-decoration-none">Hai dimenticato la password?</a>
</div>

<hr class="my-4">

<div class="text-center">
    <p class="text-muted mb-2">Non hai ancora un account?</p>
    <a href="/register.php" class="btn btn-outline-primary">
        <span class="bi bi-person-plus me-2" aria-hidden="true"></span>Registrati
    </a>
</div>

<?php
$templateParams['content'] = ob_get_clean();

require_once __DIR__ . '/template/auth-base.php';
?>