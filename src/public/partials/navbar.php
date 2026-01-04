<?php
if (!isset($menuItems)) {
    $menuItems = [];
}
?>
<nav class="navbar navbar-dark bg-primary navbar-expand-md sticky-top">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-md-center">
            <a class="navbar-brand mb-0 h1" href="index.php">UniMatch</a>
            <div class="small text-white opacity-75 mt-1 mt-md-0 ms-md-2">Trova i compagni di progetto perfetti
            </div>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-md-auto align-items-center">
                <?php foreach ($menuItems as $item): ?>
                    <li class="nav-item">
                        <a href="<?php echo htmlspecialchars($item['link']); ?>"
                            class="nav-link <?php echo (isset($item['active']) && $item['active']) ? 'active' : ''; ?>"
                            <?php echo (isset($item['active']) && $item['active']) ? 'aria-current="page"' : ''; ?>>
                            <?php echo htmlspecialchars($item['label']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li class="nav-item ms-md-2 mt-2 mt-md-0">
                        <a href="login.php" class="btn btn-outline-light btn-sm">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>