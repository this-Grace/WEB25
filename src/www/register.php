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
    // TODO: Implementare la logica di registrazione
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $university = trim($_POST['university'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $terms = isset($_POST['terms']);

    // Placeholder per la validazione
    if (empty($name) || empty($surname) || empty($email) || empty($university) || empty($password) || empty($confirmPassword)) {
        $error = 'Tutti i campi sono obbligatori';
    } elseif ($password !== $confirmPassword) {
        $error = 'Le password non coincidono';
    } elseif (strlen($password) < 8) {
        $error = 'La password deve essere di almeno 8 caratteri';
    } elseif (!$terms) {
        $error = 'Devi accettare i termini e condizioni';
    } else {
        // TODO: Salvare l'utente nel database
        $success = 'Registrazione completata! Puoi ora effettuare il login.';
    }
}

$templateParams['pageTitle'] = 'Registrati';

ob_start();
?>

<div class="text-center mb-4">
    <i class="bi bi-heart-fill text-primary" style="font-size: 3rem;"></i>
    <h1 class="h3 mt-3 fw-bold">Unisciti a UniMatch</h1>
    <p class="text-muted">Crea il tuo account e inizia a connetterti</p>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<form method="POST" action="/register.php">
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required autofocus>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Cognome" value="<?php echo htmlspecialchars($_POST['surname'] ?? ''); ?>" required>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" placeholder="tua.email@università.it" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
        </div>
    </div>

    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-building"></i></span>
            <select class="form-select" id="university" name="university" required>
                <option value="">Seleziona la tua università</option>
                <option value="unibo">Università di Bologna</option>
                <option value="unimi">Università di Milano</option>
                <option value="uniroma">Sapienza Università di Roma</option>
                <option value="unipd">Università di Padova</option>
                <option value="unifi">Università di Firenze</option>
                <option value="polimi">Politecnico di Milano</option>
                <option value="polito">Politecnico di Torino</option>
                <option value="other">Altra università</option>
            </select>
        </div>
    </div>

    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password (min. 8 caratteri)" required>
        </div>
    </div>

    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Conferma password" required>
        </div>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
        <label class="form-check-label" for="terms">
            Accetto i <a href="/terms.php" target="_blank" class="text-decoration-none">termini e condizioni</a> e la <a href="/privacy.php" target="_blank" class="text-decoration-none">privacy policy</a>
        </label>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-person-plus me-2"></i>Registrati
        </button>
    </div>
</form>

<hr class="my-4">

<div class="text-center">
    <p class="text-muted mb-2">Hai già un account?</p>
    <a href="/login.php" class="btn btn-outline-primary">
        <i class="bi bi-box-arrow-in-right me-2"></i>Accedi
    </a>
</div>

<?php
$templateParams['content'] = ob_get_clean();

require_once __DIR__ . '/template/auth-base.php';
?>