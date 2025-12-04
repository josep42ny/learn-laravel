<?php

$router->get('/', 'home.php');
$router->get('/contact', 'contact.php');
$router->get('/about', 'about.php');

$router->get('/notes', 'NotesController', 'index')->only('auth');
$router->get('/note', 'NotesController', 'show')->only('auth');
$router->delete('/note',  'NotesController', 'destroy')->only('auth');
$router->get('/notes/create', 'NotesController', 'create')->only('auth');
$router->post('/notes', 'NotesController', 'store')->only('auth');
$router->get('/note/edit', 'NotesController', 'edit')->only('auth');
$router->patch('/notes', 'NotesController', 'update')->only('auth');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'sessions/create.php')->only('guest');
$router->post('/sessions', 'sessions/store.php')->only('guest');
$router->delete('/sessions', 'sessions/destroy.php')->only('auth');

$router->get('/api/v1/notes', 'NotesClient', 'getAll');
$router->post('/api/v1/notes', 'NotesClient', 'store'); //TODO
$router->get('/api/v1/notes/{id}', 'NotesClient', 'getOne');
$router->patch('/api/v1/notes/{id}', 'NotesClient', 'edit'); //TODO
$router->delete('/api/v1/notes/{id}', 'NotesClient', 'destroy');
