<?php
$navbarBg = "primary";
$navItems = $navItems ?? [
    ['label' => 'Home', 'url' => '/index.php', 'icon' => 'bi bi-house-door'],
    ['label' => 'Crea', 'url' => '/create-post.php', 'icon' => 'bi bi-plus-circle'],
    ['label' => 'Chat', 'url' => '/chat.php', 'icon' => 'bi bi-chat-dots'],
    ['label' => 'Profilo', 'url' => '/profile.php', 'icon' => 'bi bi-person-circle'],
    ['label' => 'Logout', 'url' => '/logout.php', 'icon' => 'bi bi-box-arrow-right'],
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
