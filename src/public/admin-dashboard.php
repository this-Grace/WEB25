<?php
$pageTitle = 'Admin Dashboard';

// Statistiche
$stats = [
    'total_users' => 1234,
    'active_posts' => 456,
    'pending_reports' => 23,
    'completed_matches' => 789,
    'users_growth' => '+12%',
    'posts_growth' => '+8%',
    'matches_growth' => '+5%'
];

$adminContent = <<<'HTML'
<div class="mb-4">
    <h1 class="h3">Dashboard Admin</h1>
    <p class="text-body-secondary">Panoramica del sistema UniMatch</p>
</div>

<!-- Statistiche -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Utenti totali</h6>
                <h3 class="h2 mb-0">PHP_STAT_USERS</h3>
                <small class="text-success">PHP_STAT_USERS_GROWTH</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Post attivi</h6>
                <h3 class="h2 mb-0">PHP_STAT_POSTS</h3>
                <small class="text-success">PHP_STAT_POSTS_GROWTH</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Segnalazioni pendenti</h6>
                <h3 class="h2 mb-0">PHP_STAT_REPORTS</h3>
                <small class="text-danger">Richiedono attenzione</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card border-0 rounded-5 bg-body-tertiary">
            <div class="card-body p-4">
                <h6 class="text-body-secondary small mb-2">Match completati</h6>
                <h3 class="h2 mb-0">789</h3>
                <small class="text-success">PHP_STAT_MATCHES_GROWTH</small>
            </div>
        </div>
    </div>
</div>
HTML;

// Sostituire i placeholder con i dati reali
$adminContent = str_replace('PHP_STAT_USERS', $stats['total_users'], $adminContent);
$adminContent = str_replace('PHP_STAT_POSTS', $stats['active_posts'], $adminContent);
$adminContent = str_replace('PHP_STAT_REPORTS', $stats['pending_reports'], $adminContent);
$adminContent = str_replace('PHP_STAT_USERS_GROWTH', $stats['users_growth'] . ' questo mese', $adminContent);
$adminContent = str_replace('PHP_STAT_POSTS_GROWTH', $stats['posts_growth'] . ' questo mese', $adminContent);
$adminContent = str_replace('PHP_STAT_MATCHES_GROWTH', $stats['matches_growth'] . ' questo mese', $adminContent);

$content = $adminContent;

include 'template/admin.php';
