<?php

$templateParams['title'] = "Home";
$templateParams['css'] = ['assets/css/home.css'];
$templateParams['js'] = ['assets/js/filters.js'];

$templateParams['content'] = "partials/homepage.php";

$templateParams['categories'] = [
    ['href' => '#filter-tutti', 'class' => 'btn-cate active', 'label' => 'Tutti'],
    ['href' => '#filter-conferenze', 'class' => 'btn-cate btn-cate-conferenze', 'label' => 'Conferenze'],
    ['href' => '#filter-workshop', 'class' => 'btn-cate btn-cate-workshop', 'label' => 'Workshop'],
    ['href' => '#filter-seminari', 'class' => 'btn-cate btn-cate-seminari', 'label' => 'Seminari'],
    ['href' => '#filter-networking', 'class' => 'btn-cate btn-cate-networking', 'label' => 'Networking'],
    ['href' => '#filter-sport', 'class' => 'btn-cate btn-cate-sport', 'label' => 'Sport'],
    ['href' => '#filter-sociali', 'class' => 'btn-cate btn-cate-social', 'label' => 'Social'],
];

$templateParams['featured_events'] = [
    [
        'img' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop',
        'img_alt' => "Audience listening to a speaker at an artificial intelligence conference presentation",
        'badge_class' => 'badge badge-cate-conferenze position-absolute top-0 start-0 m-3',
        'category_label' => 'Conferenze',
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
