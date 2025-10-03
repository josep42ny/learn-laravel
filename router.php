<?php

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = [
  '/' => 'controllers/home.php',
  '/contact' => 'controllers/contact.php',
  '/about' => 'controllers/about.php',
];

routeToController($url, $routes);
