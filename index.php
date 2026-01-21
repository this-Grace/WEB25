<?php

$templateParams['navlinks'] = [
    ['href' => '/', 'label' => 'Home'],
    ['href' => '/about', 'label' => 'Chi Siamo'],
    ['href' => '/services', 'label' => 'Servizi'],
    ['href' => '/contact', 'label' => 'Contatti']
];

$templateParams["content"] = "view/index-view.php";

require 'template/base.php';
