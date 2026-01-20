<?php
session_start();

if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$hideNavbar = true;
$authContent = isset($content) ? $content : '';
$ariaLabel = $ariaLabel ?? ($pageTitle ?? 'Auth form');

$content = <<<HTML
<main class="auth-page d-flex align-items-center justify-content-center flex-grow-1">
    <div class="container">
        <div class="row auth-grid align-items-center justify-content-center g-5">
            <div class="col-lg-6 d-none d-lg-flex justify-content-center">
                <img src="assets/img/banner.png" alt="Illustrazione collaborativa per UniMatch"
                    class="img-fluid auth-hero">
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="auth-panel" role="form" aria-label="<?= htmlspecialchars($ariaLabel ?? 'Auth form') ?>">
                    $authContent
                </div>
            </div>
        </div>
    </div>
</main>
HTML;

include 'base.php';
