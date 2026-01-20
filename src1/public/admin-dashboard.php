<?php
$pageTitle = 'Admin Dashboard';
require_once __DIR__ . '/../app/User.php';
require_once __DIR__ . '/../app/Post.php';
require_once __DIR__ . '/../app/Report.php';

try {
    $userModel = new User();
    $postModel = new Post();
    $reportModel = new Report();

    $usersGrowth = $userModel->getMonthlyGrowth();
    $postsGrowth = $postModel->getMonthlyGrowth();

    $statsCards = [
        [
            'title' => 'Utenti totali',
            'value' => $userModel->count(),
            'growth' => ($usersGrowth >= 0 ? '+' : '-') . $usersGrowth . '% questo mese',
            'badge_class' => 'text-success'
        ],
        [
            'title' => 'Post attivi',
            'value' => $postModel->count(),
            'growth' => ($postsGrowth >= 0 ? '+' : '-') . $postsGrowth . '% questo mese',
            'badge_class' => 'text-success'
        ],
        [
            'title' => 'Post in attesa',
            'value' => $postModel->countPending(),
            'growth' => 'Richiedono approvazione',
            'badge_class' => 'text-warning'
        ],
        [
            'title' => 'Segnalazioni pendenti',
            'value' => $reportModel->getStats()['pending'] ?? 0,
            'growth' => 'Richiedono attenzione',
            'badge_class' => 'text-danger'
        ]
    ];
} catch (Exception $e) {
    error_log('Admin Dashboard Error: ' . $e->getMessage());
    $statsCards = [
        [
            'title' => 'Utenti totali',
            'value' => 0,
            'growth' => 'N/A',
            'badge_class' => 'text-muted'
        ],
        [
            'title' => 'Post attivi',
            'value' => 0,
            'growth' => 'N/A',
            'badge_class' => 'text-muted'
        ],
        [
            'title' => 'Post in attesa',
            'value' => 0,
            'growth' => 'N/A',
            'badge_class' => 'text-muted'
        ],
        [
            'title' => 'Segnalazioni pendenti',
            'value' => 0,
            'growth' => 'N/A',
            'badge_class' => 'text-muted'
        ]
    ];
}

$adminContent = <<<HTML
<div class="mb-4">
    <h1 class="h3">Dashboard Admin</h1>
    <p class="text-body-secondary">Panoramica del sistema UniMatch</p>
</div>

<!-- Statistiche -->
<div class="row g-3 mb-4">
HTML;

foreach ($statsCards as $card) {
    $adminContent .= <<<HTML
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h2 class="text-body-secondary small mb-2">{$card['title']}</h2>
                <h3 class="h2 mb-0">{$card['value']}</h3>
                <small class="{$card['badge_class']}">{$card['growth']}</small>
            </div>
        </div>
    </div>
HTML;
}

$adminContent .= <<<HTML
</div>
HTML;

$content = $adminContent;

include 'template/admin.php';
