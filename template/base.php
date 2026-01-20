<?php
$templateParams['brandName'] = "Brand";
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($templateParams['brandName']) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <?php echo htmlspecialchars($templateParams['brandName']) ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <?php foreach ($templateParams['navlinks'] as $link): ?>
                        <li class="nav-item<?php echo $link['active'] ? ' active' : ''; ?>">
                            <a class="nav-link<?php echo $link['disabled'] ? ' disabled' : ''; ?>" href="<?php echo htmlspecialchars($link['href']); ?>">
                                <?php echo htmlspecialchars($link['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <?php
        if (isset($templateParams["content"])) {
            // require($templateParams["content"]);
        }
        ?>
    </main>

    <footer class="mt-auto py-4">
        <div class="container">
            <div class="row align-items-center gy-2">
                <div class="col-12 col-md text-center text-md-start text-body-secondary small">
                    &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($templateParams['brandName']) ?> — Tutti i diritti riservati
                </div>
                <div class="col-12 col-md-auto">
                    <ul class="nav justify-content-center">
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>