<?php
if (!isset($menuItems)) {
    $menuItems = [];
}
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentFile = basename($_SERVER['PHP_SELF']);

$pages = [
    'index.php'       => 'home',
    'create-post.php' => 'create',
    'chat.php'        => 'chat',
    'profile.php'     => 'profile',
];

$activePage = $pages[$currentFile] ?? '';
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

                <li class="nav-item">
                    <a href="index.php"
                       class="nav-link <?= $activePage === 'home' ? 'active' : '' ?>"
                       <?= $activePage === 'home' ? 'aria-current="page"' : '' ?>>
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a href="create-post.php"
                       class="nav-link <?= $activePage === 'create' ? 'active' : '' ?>"
                       <?= $activePage === 'create' ? 'aria-current="page"' : '' ?>>
                        Crea
                    </a>
                </li>

                <li class="nav-item">
                    <a href="chat.php"
                       class="nav-link <?= $activePage === 'chat' ? 'active' : '' ?>"
                       <?= $activePage === 'chat' ? 'aria-current="page"' : '' ?>>
                        Chat
                    </a>
                </li>

                <li class="nav-item">
                    <a href="profile.php"
                       class="nav-link <?= $activePage === 'profile' ? 'active' : '' ?>"
                       <?= $activePage === 'profile' ? 'aria-current="page"' : '' ?>>
                        Profilo
                    </a>
                </li>

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