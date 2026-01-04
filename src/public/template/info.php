<?php
if (!isset($pageTitle) || !isset($sections)) {
    die('Errore: variabili mancanti');
}

ob_start();
?>

<div class="mb-5">
    <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($pageTitle) ?></h1>
    <p class="text-muted">Ultimo aggiornamento: 4 Gennaio 2026</p>
</div>

<div class="content">
    <?php foreach ($sections as $section): ?>
        <section class="mb-5">
            <h2 class="h4 mb-3"><?= htmlspecialchars($section['title']) ?></h2>
            <p>
                <?= htmlspecialchars($section['text']) ?>
                <?php if (isset($section['email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($section['email']) ?>"><?= htmlspecialchars($section['email']) ?></a>
                <?php endif; ?>
            </p>
            <?php if (isset($section['list'])): ?>
                <ul>
                    <?php foreach ($section['list'] as $item): ?>
                        <li><?= htmlspecialchars($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
include 'base.php';
?>