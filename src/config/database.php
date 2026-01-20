<?php

require_once __DIR__ . '/../app/DatabaseHelper.php';

$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'web25',
    'user' => 'root',
    'pass' => '',
    'charset' => 'utf8mb4',
    'port' => 3306
];

// Inizializza l'istanza globale del DatabaseHelper
$dbh = new DatabaseHelper(
    $dbConfig['host'],
    $dbConfig['user'],
    $dbConfig['pass'],
    $dbConfig['dbname'],
    $dbConfig['port'],
    $dbConfig['charset']
);
