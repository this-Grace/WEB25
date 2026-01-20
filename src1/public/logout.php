<?php

require_once __DIR__ . '/../app/functions.php';

session_start();
session_unset();
session_destroy();
redirect('login.php');
exit;
