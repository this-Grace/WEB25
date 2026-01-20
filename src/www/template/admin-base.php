<?php
$templateParams = $templateParams ?? [];
$templateParams['navbarBg'] = $templateParams['navbarBg'] ?? 'danger';
$templateParams['navItems'] = $templateParams['navItems'] ?? [
	['label' => 'Home', 'url' => '/index.php', 'icon' => 'bi bi-house-door'],
];

$userContent = $templateParams['userContent'] ?? '';

$templateParams['content'] = <<<HTML
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-lg-9 col-xl-8">
			$userContent
		</div>
	</div>
</div>
HTML;

include __DIR__ . '/base.php';
