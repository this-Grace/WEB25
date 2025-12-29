<?php
$currentPage = $activePage ?? 'home';
$navItems = [
    'home' => ['url' => 'index.php', 'label' => 'Home'],
    'create' => ['url' => 'create-post.php', 'label' => 'Crea'],
    'chat' => ['url' => 'chat.php', 'label' => 'Chat'],
    'profile' => ['url' => 'profile.php', 'label' => 'Profilo']
];
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
                <?php foreach ($navItems as $page => $item): ?>
                    <li class="nav-item">
                        <a href="<?= $item['url'] ?>"
                            class="nav-link <?= $currentPage === $page ? 'active' : '' ?>"
                            <?= $currentPage === $page ? 'aria-current="page"' : '' ?>>
                            <?= $item['label'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="themeDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2" id="themeIcon">◐</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
                        <li><button type="button" class="dropdown-item d-flex align-items-center"
                                data-theme-value="auto"><span class="me-2">◐</span> Automatico</button></li>
                        <li><button type="button" class="dropdown-item d-flex align-items-center"
                                data-theme-value="light"><span class="me-2">○</span> Chiaro</button></li>
                        <li><button type="button" class="dropdown-item d-flex align-items-center"
                                data-theme-value="dark"><span class="me-2">●</span> Scuro</button></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>