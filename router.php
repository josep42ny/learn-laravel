<?php

$routes = require 'routes.php';

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

routeToController($url, $routes);
