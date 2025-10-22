<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/'); // zmienna globalna server
$path = parse_url($path, PHP_URL_PATH);

// var_dump($path);

Routing::run($path);

?>