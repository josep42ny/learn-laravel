<?php

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'Core/functions.php';

spl_autoload_register(function ($class) {
  $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
  require baseUrl($class . '.php');
});

$router = new Core\Router();

$routes = require baseUrl('routes.php');

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($url, $method);
