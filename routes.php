<?php

$router->get('/', 'controllers/home.php');

$router->get('/notes', 'controllers/notes/index.php')->only('auth');

$router->get('/note', 'controllers/notes/show.php')->only('auth');
$router->delete('/note', 'controllers/notes/destroy.php')->only('auth');

$router->get('/notes/create', 'controllers/notes/create.php')->only('auth');
$router->post('/notes', 'controllers/notes/store.php')->only('auth');

$router->get('/note/edit', 'controllers/notes/edit.php')->only('auth');
$router->patch('/notes', 'controllers/notes/update.php')->only('auth');

$router->get('/contact', 'controllers/contact.php');

$router->get('/about', 'controllers/about.php');

$router->get('/register', 'controllers/registration/create.php')->only('guest');
$router->post('/register', 'controllers/registration/store.php')->only('guest');

$router->get('/login', 'controllers/sessions/create.php')->only('guest');
$router->post('/sessions', 'controllers/sessions/store.php')->only('guest');
$router->delete('/sessions', 'controllers/sessions/destroy.php')->only('auth');
