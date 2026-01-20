<?php
$templateParams = $templateParams ?? [];
$templateParams['navbarBg'] = $templateParams['navbarBg'] ?? 'danger';
$templateParams['navItems'] = [
    ['label' => 'Dashboard', 'url' => '/admin-dashboard.php', 'icon' => 'bi bi-speedometer2'],
    ['label' => 'Utenti', 'url' => '/admin-users.php', 'icon' => 'bi bi-people'],
    ['label' => 'Post', 'url' => '/admin-posts.php', 'icon' => 'bi bi-chat-dots'],
    ['label' => 'Report', 'url' => '/admin-reports.php', 'icon' => 'bi bi-flag'],
];

$userContent = $templateParams['userContent'] ?? '';

$templateParams['content'] = <<<HTML
<div class="container py-5">
	<div class="content row justify-content-center">
		<div class="col-lg-12 col-xl-12">
			$userContent
		</div>
	</div>
</div>
HTML;

include __DIR__ . '/base.php';
