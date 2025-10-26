<?php

use Core\App;
use Core\Validator;
use Core\Database;

$db = App::resolve(Database::class);
$errors = [
  'title' => [],
  'body' => [],
];


if (!Validator::string($_POST['title'], 1, 50)) {
  array_push($errors['title'], 'Invalid title lenght.');
}

if (!Validator::string($_POST['body'], 1, 1000)) {
  array_push($errors['body'], 'Invalid body lenght.');
}

$hasError = false;
foreach ($errors as $error) {
  if (!empty($error)) {
    $hasError = true;
    break;
  }
}

if ($hasError) {
  return view('notes/create.view.php', [
    'heading' => 'Create a note',
    'errors' => $errors,
  ]);
}

$db->query('insert into Note(title, body, userId) values (:title, :body, :uid)', [
  'title' => $_POST['title'],
  'body' => $_POST['body'],
  'uid' => 1
]);

redirect('/notes');
