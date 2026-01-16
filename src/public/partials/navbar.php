<?php
if (!isset($menuItems)) {
    $menuItems = [];
}
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pages = [
    'index.php'       => ['label' => 'Home', 'key' => 'home'],
    'create-post.php' => ['label' => 'Crea', 'key' => 'create'],
    'chat.php'        => ['label' => 'Chat', 'key' => 'chat'],
    'profile.php'     => ['label' => 'Profilo', 'key' => 'profile'],
];

$currentFile = basename($_SERVER['PHP_SELF']);
$activePageKey = $pages[$currentFile]['key'] ?? '';
?>

<nav class="navbar navbar-dark bg-primary navbar-expand-md">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">UniMatch</a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">

                <?php foreach ($pages as $file => $info): 
                    $isActive = $activePageKey === $info['key'];
                ?>
                    <li class="nav-item">
                        <a href="<?= $file ?>"
                           class="nav-link <?= $isActive ? 'active' : '' ?>"
                           <?= $isActive ? 'aria-current="page"' : '' ?>>
                            <?= htmlspecialchars($info['label']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>

                <!-- THEME SWITCHER -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center"
                       href="#" id="themeDropdown"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2" id="themeIcon">◐</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item" data-theme-value="auto">◐ Automatico</button></li>
                        <li><button class="dropdown-item" data-theme-value="light">○ Chiaro</button></li>
                        <li><button class="dropdown-item" data-theme-value="dark">● Scuro</button></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>