<?php
$templateParams = $templateParams ?? [];
$templateParams['brandName'] = $templateParams['brandName'] ?? 'UniMatch';
$templateParams['brandUrl'] = $templateParams['brandUrl'] ?? '/index.php';
$templateParams['brandIcon'] = $templateParams['brandIcon'] ?? 'bi bi-heart-fill';
$templateParams['navItems'] = $templateParams['navItems'] ?? [];
$templateParams['navbarBg'] = $templateParams['navbarBg'] ?? 'primary';
$templateParams['navbarVariant'] = $templateParams['navbarVariant'] ?? (in_array($templateParams['navbarBg'], ['dark', 'primary', 'secondary', 'success', 'danger', 'info']) ? 'dark' : 'light');
$templateParams['footerLinks'] = $templateParams['footerLinks'] ?? [
    ['label' => 'Privacy', 'url' => '/privacy.php'],
    ['label' => 'Termini', 'url' => '/terms.php'],
];
$templateParams['description'] = $templateParams['description'] ?? 'UniMatch - Connetti con studenti universitari';
$templateParams['pageTitle'] = $templateParams['pageTitle'] ?? '';
$templateParams['content'] = $templateParams['content'] ?? '';
?>

<!DOCTYPE html>
<html lang="it" xml:lang="it" dir="ltr" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($templateParams['description']); ?>">
    <title>UniMatch<?php echo !empty($templateParams['pageTitle']) ? ' | ' . htmlspecialchars($templateParams['pageTitle']) : ''; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <main class="flex-grow-1">
        <?php echo $templateParams['content']; ?>
    </main>

    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>