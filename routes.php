<?php

$router->get('/', 'home.php');
$router->get('/contact', 'contact.php');
$router->get('/about', 'about.php');

$router->get('/notes', 'NotesController', 'index')->only('loggedIn');
$router->get('/note', 'NotesController', 'show')->only('loggedIn');
$router->delete('/note',  'NotesController', 'destroy')->only('loggedIn');
$router->get('/notes/create', 'NotesController', 'create')->only('loggedIn');
$router->post('/notes', 'NotesController', 'store')->only('loggedIn');
$router->get('/note/edit', 'NotesController', 'edit')->only('loggedIn');
$router->patch('/notes', 'NotesController', 'update')->only('loggedIn');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'sessions/create.php')->only('guest');
$router->post('/sessions', 'sessions/store.php')->only('guest');
$router->delete('/sessions', 'sessions/destroy.php')->only('loggedIn');

$router->get('/api/v1/notes', 'NotesClient', 'getAll');
$router->post('/api/v1/notes', 'NotesClient', 'store');
$router->get('/api/v1/notes/{id}', 'NotesClient', 'getOne');
$router->patch('/api/v1/notes/{id}', 'NotesClient', 'edit');
$router->delete('/api/v1/notes/{id}', 'NotesClient', 'destroy');
$router->post('/api/v1/users/auth', 'UsersClient', 'getToken');
$router->delete('/api/v1/users/auth', 'UsersClient', 'deleteToken');
