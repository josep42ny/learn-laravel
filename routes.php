<?php

$router->get('/', 'home.php');
$router->get('/contact', 'contact.php');
$router->get('/about', 'about.php');

$router->get('/notes', 'notes/index.php')->only('auth');

$router->get('/note', 'notes/show.php')->only('auth');
$router->delete('/note', 'notes/destroy.php')->only('auth');

$router->get('/notes/create', 'notes/create.php')->only('auth');
$router->post('/notes', 'notes/store.php')->only('auth');

$router->get('/note/edit', 'notes/edit.php')->only('auth');
$router->patch('/notes', 'notes/update.php')->only('auth');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'sessions/create.php')->only('guest');
$router->post('/sessions', 'sessions/store.php')->only('guest');
$router->delete('/sessions', 'sessions/destroy.php')->only('auth');
