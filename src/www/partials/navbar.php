<nav class="navbar navbar-expand-lg navbar-<?= htmlspecialchars($templateParams['navbarVariant']) ?> bg-<?= htmlspecialchars($templateParams['navbarBg']) ?>">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= htmlspecialchars($templateParams['brandUrl']) ?>">
            <?php if (!empty($templateParams['brandIcon'])): ?>
                <span class="<?= htmlspecialchars($templateParams['brandIcon']) ?>" aria-hidden="true"></span>
            <?php endif; ?>
            <span><?= htmlspecialchars($templateParams['brandName']) ?></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php
                $currentPage = $_SERVER['REQUEST_URI'];
                foreach ($templateParams['navItems'] as $item):
                    $isActive = ($currentPage === $item['url']) || (basename($currentPage) === basename($item['url']));
                ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2<?= $isActive ? ' active' : '' ?>"
                            href="<?= htmlspecialchars($item['url']) ?>"
                            <?= $isActive ? 'aria-current="page"' : '' ?>>
                            <?php if (!empty($item['icon'])): ?>
                                <span class="<?= htmlspecialchars($item['icon']) ?>" aria-hidden="true"></span>
                            <?php endif; ?>
                            <span><?= htmlspecialchars($item['label']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>