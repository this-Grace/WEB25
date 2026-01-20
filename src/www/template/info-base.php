<?php
$templateParams = $templateParams ?? [];
$templateParams['navbarBg'] = $templateParams['navbarBg'] ?? 'success';
$sections = $templateParams['sections'] ?? null;
$pageTitle = $templateParams['pageTitle'] ?? '';
$content = $templateParams['content'] ?? null;

if (!isset($content) && isset($sections)) {
    $lastUpdated = $templateParams['lastUpdated'] ?? null;
    ob_start();
?>
    <div class="container py-5">
        <div class="mb-5">
            <?php if (!empty($pageTitle)): ?>
                <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($pageTitle) ?></h1>
            <?php endif; ?>
            <?php if (!empty($lastUpdated)): ?>
                <p class="text-muted">Ultimo aggiornamento: <?= htmlspecialchars($lastUpdated) ?></p>
            <?php endif; ?>
        </div>

        <div class="content">
            <?php foreach ($sections as $section): ?>
                <section class="mb-5">
                    <?php if (!empty($section['title'])): ?>
                        <h2 class="h4 mb-3"><?= htmlspecialchars($section['title']) ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($section['text']) || !empty($section['email'])): ?>
                        <p>
                            <?= !empty($section['text']) ? nl2br(htmlspecialchars($section['text'])) : '' ?>
                            <?php if (!empty($section['email'])): ?>
                                <a href="mailto:<?= htmlspecialchars($section['email']) ?>"><?= htmlspecialchars($section['email']) ?></a>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($section['list']) && is_array($section['list'])): ?>
                        <ul>
                            <?php foreach ($section['list'] as $item): ?>
                                <li><?= htmlspecialchars($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
<?php
    $templateParams['content'] = ob_get_clean();
} elseif (!isset($content)) {
    $templateParams['content'] = '<div class="container py-5"><p class="text-muted mb-0">Nessun contenuto disponibile.</p></div>';
}

include __DIR__ . '/base.php';
