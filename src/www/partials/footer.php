<footer class="mt-auto py-4">
    <div class="container">
        <div class="row align-items-center gy-2">
            <div class="col-12 col-md text-center text-md-start text-body-secondary small">
                &copy; <?php echo date('Y'); ?> <?php echo $siteName ?> — Tutti i diritti riservati
            </div>
            <div class="col-12 col-md-auto">
                <ul class="nav justify-content-center">
                    <?php foreach ($footerLinks as $link): ?>
                        <li class="nav-item"><a href="<?php echo htmlspecialchars($link['url']); ?>" class="nav-link px-2 text-body-secondary"><?php echo htmlspecialchars($link['label']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</footer>