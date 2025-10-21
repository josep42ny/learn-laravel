<?php

$router->get('/', 'controllers/home.php');
$router->get('/notes', 'controllers/notes/index.php');
$router->get('/note', 'controllers/notes/show.php');
$router->get('/notes/create', 'controllers/notes/create.php');
$router->post('/notes/create', 'controllers/notes/create.php');
$router->get('/contact', 'controllers/contact.php');
$router->get('/about', 'controllers/about.php');
