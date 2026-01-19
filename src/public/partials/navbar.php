<?php
session_status() === PHP_SESSION_NONE && session_start();
$menuItems = $menuItems ?? [];
$navbarColor = $navbarColor ?? 'primary';
$brandUrl = $brandUrl ?? 'index.php';

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-dark bg-<?= htmlspecialchars($navbarColor) ?> navbar-expand-md">
    <div class="container">

        <a class="navbar-brand fw-bold" href="<?= htmlspecialchars($brandUrl) ?>">UniMatch</a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <?php if (!empty($_SESSION['username'])): ?>
                    <?php foreach ($menuItems as $item): ?>
                        <?php $isActive = basename($item['url']) === $currentPage ? 'active' : ''; ?>
                        <li class="nav-item">
                            <a href="<?= htmlspecialchars($item['url']) ?>" class="nav-link <?= $isActive ?>"><?= htmlspecialchars($item['label']) ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-outline-light">Accedi</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>