<?php
$navbarBg = "danger";
$navItems = $navItems ?? [
	['label' => 'Home', 'url' => '/index.php', 'icon' => 'bi bi-house-door'],
];

$userContent = $userContent ?? '';

$content = <<<HTML
<main class="flex-grow-1 py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-9 col-xl-8">
				$userContent
			</div>
		</div>
	</div>
</main>
HTML;

include __DIR__ . '/base.php';
