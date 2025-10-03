<?php

use const Dom\NOT_FOUND_ERR;

require 'functions.php';

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = [
  '/' => 'controllers/home.php',
  '/contact' => 'controllers/contact.php',
  '/about' => 'controllers/about.php',
];

if (array_key_exists($url, $routes)) {
  require $routes[$url];
} else {
  http_response_code(404);
  require 'views/404.php';
}
