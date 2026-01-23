<?php

require_once __DIR__ . '/../app/bootstrap.php';

$templateParams['title'] = "Home";
$templateParams['css'] = ['assets/css/home.css'];
$templateParams['js'] = ['assets/js/filters.js'];

$templateParams['content'] = "partials/homepage.php";

$templateParams['categories'] = [
    ['href' => '#filter-tutti', 'class' => 'btn-cate active', 'label' => 'Tutti', 'id' => 'tutti'],
];

$cats = [];
try {
    $cats = $catMapper->findAll();
    foreach ($cats as $c) {
        $templateParams['categories'][] = [
            'href'  => '#filter-' . strtolower($c['name']),
            'class' => 'btn-cate btn-cate-' . strtolower($c['name']),
            'label' => ucfirst(strtolower($c['name'])),
            'id'    => (string)$c['id']
        ];
    }
} catch (Throwable $e) {
}
$templateParams["numCat"] = count($cats);

$templateParams['featured_events'] = [
    [
        'img' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop',
        'img_alt' => "Audience listening to a speaker at an artificial intelligence conference presentation",
        'badge_class' => 'badge badge-cate-conferenze position-absolute top-0 start-0 m-3',
        'category_label' => 'Conferenze',
        'category_id' => 1,
        'title' => "Conferenza sull'Intelligenza Artificiale",
        'date' => '25 Gennaio 2026 - 14:30',
        'location' => 'Aula Magna - Edificio A',
        'attendees' => '87/150 iscritti',
        'cta_label' => "Iscriviti all'evento",
        'cta_href' => '#',
    ],
];

$templateParams['stats'] = [
    ['card_class' => 'stat-card stat-card-blue p-4', 'icon' => 'bi bi-calendar-event', 'value' => '28', 'label' => 'Eventi Questo Mese'],
    ['card_class' => 'stat-card stat-card-green p-4', 'icon' => 'bi bi-percent', 'value' => '89%', 'label' => 'Partecipazione Media'],
    ['card_class' => 'stat-card stat-card-orange p-4', 'icon' => 'bi bi-check-circle', 'value' => '188', 'label' => 'Eventi Completati'],
];


require 'template/base.php';
