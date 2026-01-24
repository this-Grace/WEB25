<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$templateParams["brand"] = "UniEvents";
$templateParams["tagline"] = "Il futuro dei tuoi eventi universitari, oggi.";

$navClass = function (string $label) use ($templateParams): string {
    return 'nav-link px-3 ' . (($templateParams['title'] ?? '') === $label ? 'active bg-dark text-white' : 'link-dark');
};
?>

<!DOCTYPE html>
<html lang="it" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($templateParams['brand'], ENT_QUOTES, 'UTF-8') . " | " . htmlspecialchars($templateParams['title'], ENT_QUOTES, 'UTF-8'); ?></title>

    <link rel="stylesheet" href="assets/css/style.css">

    <?php if (!empty($templateParams['css']) && is_array($templateParams['css'])): ?>
        <?php foreach ($templateParams['css'] as $stylesheet) : ?>
            <link rel="stylesheet" href="<?php echo htmlspecialchars($stylesheet, ENT_QUOTES, 'UTF-8'); ?>">
        <?php endforeach ?>
    <?php endif; ?>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="d-flex flex-column vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-2">
        <div class="container flex-column flex-lg-row">
            <a class="navbar-brand d-flex align-items-center mx-auto mx-lg-0 mb-2 mb-lg-0" href="index.php">
                <span class="bi bi-calendar-check-fill fs-3 text-primary me-2" aria-hidden="true"></span>
                <span class="fs-4 fw-bold tracking-tight"><?php echo htmlspecialchars($templateParams['brand'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            </a>

            <ul class="nav nav-pills justify-content-center mt-md-2">
                <li class="nav-item">
                    <a href="index.php" class="<?php echo $navClass('Home'); ?>">Home</a>
                </li>

                <?php if (isset($_SESSION['user']['role']) && in_array(strtolower($_SESSION['user']['role']), ['admin', 'host'], true)): ?>
                    <li class="nav-item">
                        <a href="create.php" class="<?php echo $navClass('Crea Evento'); ?>">Crea Evento</a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a href="profile.php" class="<?php echo $navClass('Profilo'); ?>">Profilo</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger px-3">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link text-primary px-3">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <?php
    require $templateParams["content"];
    ?>

    <footer class="bg-dark text-white py-5" aria-label="Footer">
        <div class="container">
            <div class="row text-center text-md-start g-4 align-items-start">

                <div class="col-12 col-md-4">
                    <h2 class="h5 text-primary fw-bold mb-2">UniEvents</h2>
                    <p class="small text-white-50 mb-0">Il futuro dei tuoi eventi universitari, oggi.</p>
                </div>

                <div class="col-6 col-md-4">
                    <h3 class="h6 text-uppercase mb-2 small fw-bold text-white">Developer</h3>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">
                            <span class="bi bi-envelope text-primary me-2" aria-hidden="true"></span>
                            <a href="mailto:alessandro.rebosio@studio.unibo.it" class="text-white-50 text-decoration-none">
                                Alessandro Rebosio </a><br />
                            <span class="bi bi-envelope text-primary me-2" aria-hidden="true"></span>
                            <a href="mailto:grazia.bochdanovits@studio.unibo.it" class="text-white-50 text-decoration-none">
                                Grazia Bochdanovits de Kavna </a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-md-4">
                    <h3 class="h6 text-uppercase mb-2 small fw-bold text-white">Info</h3>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">Termini e Condizioni</a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-4 border-secondary">

            <div class="text-center small text-white-50">
                &copy; <?php echo date('Y'); ?> <strong><?php echo htmlspecialchars($templateParams['brand']); ?></strong>. Tutti i diritti riservati.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <?php if (!empty($templateParams['js']) && is_array($templateParams['js'])): ?>
        <?php foreach ($templateParams['js'] as $script) : ?>
            <script src="<?php echo htmlspecialchars($script); ?>"></script>
        <?php endforeach ?>
    <?php endif; ?>
</body>

</html>