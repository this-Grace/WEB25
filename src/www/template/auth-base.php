<?php
$templateParams = $templateParams ?? [];
$templateParams['showNavbar'] = false;
$templateParams['showFooter'] = $templateParams['showFooter'] ?? true;
$templateParams['bannerImage'] = $templateParams['bannerImage'] ?? 'assets/img/banner.png';

$authContent = $templateParams['content'];

ob_start();
?>

<div class="container py-4">
    <div class="row auth-row align-items-center">
        <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-5 auth-banner-col">
            <img src="<?php echo htmlspecialchars($templateParams['bannerImage']); ?>" alt="UniMatch" class="img-fluid auth-banner-img rounded-4">
        </div>
        <div class="col-lg-7 d-flex align-items-center justify-content-center p-4">
            <div class="row w-100 justify-content-center">
                <div class="col-sm-10 col-md-8 col-lg-11 col-xl-9">
                    <?php echo $authContent; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$templateParams['content'] = ob_get_clean();

require_once __DIR__ . '/base.php';
?>