<?php
session_start();

// Se già loggato, redirect alla home
if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = 'Inserisci il tuo indirizzo email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Indirizzo email non valido';
    } else {
        // TODO: Implementare invio email di reset password
        $success = 'Se l\'indirizzo email è registrato, riceverai le istruzioni per reimpostare la password.';
    }
}

$templateParams['pageTitle'] = 'Password dimenticata';

ob_start();
?>

<div class="text-center mb-4">
    <span class="bi bi-key text-primary" style="font-size: 3rem;" aria-hidden="true"></span>
    <h1 class="h3 mt-3 fw-bold">Password dimenticata?</h1>
    <p class="text-muted">Inserisci la tua email per reimpostare la password</p>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger" role="alert">
        <span class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></span><?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success" role="alert">
        <span class="bi bi-check-circle-fill me-2" aria-hidden="true"></span><?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<form method="POST" action="/forgot-password.php">
    <div class="mb-4">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
            <span class="input-group-text"><span class="bi bi-envelope" aria-hidden="true"></span></span>
            <input type="email" class="form-control" id="email" name="email" placeholder="tua.email@università.it" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required autofocus>
        </div>
    </div>

    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">
            <span class="bi bi-send me-2" aria-hidden="true"></span>Invia link di reset
        </button>
    </div>
</form>

<div class="text-center mt-4">
    <a href="/login.php" class="text-decoration-none">
        <span class="bi bi-arrow-left me-1" aria-hidden="true"></span>Torna al login
    </a>
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