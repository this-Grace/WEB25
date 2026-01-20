<?php
$brandName = $brandName ?? 'UniMatch';
$brandUrl = $brandUrl ?? '/index.php';
$brandIcon = $brandIcon ?? 'bi bi-heart-fill';
$navItems = $navItems ?? [];
$navbarBg = $navbarBg ?? 'primary';
$navbarVariant = $navbarVariant ?? (in_array($navbarBg, ['dark', 'primary', 'secondary', 'success', 'danger', 'info']) ? 'dark' : 'light');
$footerLinks = $footerLinks ?? [
    ['label' => 'Privacy', 'url' => '/privacy.php'],
    ['label' => 'Termini', 'url' => '/terms.php'],
];
$description = $description ?? 'UniMatch - Connetti con studenti universitari';
?>

<!DOCTYPE html>
<html lang="it" xml:lang="it" dir="ltr" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    <title>UniMatch<?php echo isset($pageTitle) && $pageTitle !== '' ? ' | ' . htmlspecialchars($pageTitle) : ''; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <main class="flex-grow-1">
        <?php echo $content ?? ''; ?>
    </main>

    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>