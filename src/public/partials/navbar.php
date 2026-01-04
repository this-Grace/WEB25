<?php
if (!isset($menuItems)) {
    $menuItems = [];
}
?>
<nav class="navbar navbar-dark bg-primary navbar-expand-md">
    <div class="container">
        <div class="d-flex flex-column">
            <a class="navbar-brand fw-bold mb-0" href="index.php">UniMatch</a>
            <span class="small text-white opacity-75 d-none d-md-block">Trova i compagni di progetto perfetti</span>
        </div>

        <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon-custom"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
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
                    <li class="nav-item">
                        <a href="login.php" class="nav-link fw-semibold">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>