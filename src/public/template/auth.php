<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniMatch <?php echo isset($pageTitle) ? '| ' . $pageTitle : ''; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <main class="auth-page d-flex align-items-center justify-content-center flex-grow-1" role="main">
        <div class="container">
            <div class="row auth-grid align-items-center justify-content-center g-5">
                <div class="col-lg-6 d-none d-lg-flex justify-content-center">
                    <img src="assets/img/banner.png" alt="Illustrazione collaborativa per UniMatch"
                        class="img-fluid auth-hero">
                </div>

                <div class="col-lg-4 col-md-6" aria-label="<?php echo isset($ariaLabel) ? $ariaLabel : 'Area'; ?>">
                    <div class="auth-panel" role="form" aria-labelledby="pageTitle">
                        <?php echo isset($content) ? $content : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>