<?php

$menuItems = $menuItems ?? [
    ['label' => 'Crea', 'url' => 'create-post.php'],
    ['label' => 'Chat', 'url' => 'chat.php'],
    ['label' => 'Profilo', 'url' => 'profile.php'],
];
$requireLogin = $requireLogin ?? true;

$userContent = $content;
$content = <<<HTML
<main class="flex-grow-1 d-flex align-items-center py-5" role="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                $userContent
            </div>
        </div>
    </div>
</main>
HTML;

include 'base.php';
