<?php

use Core\Session;

const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'Core/functions.php';
require baseUrl('bootstrap.php');

session_start();

$router = new Core\Router();
$routes = require baseUrl('routes.php');

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$router->route($url, $method);

Session::unflash();
