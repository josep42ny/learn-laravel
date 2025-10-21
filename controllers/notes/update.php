<?php

use Core\App;
use Core\Validator;
use Core\Database;

$db = App::resolve(Database::class);
$authorisedUser = 1;

$note = $db->query('select * from Note where id = :id', ['id' => $_POST['id']])->getOrFail();
authorise($note['userId'] === $authorisedUser);

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
  return view('notes/edit.view.php', [
    'heading' => 'Edit note',
    'errors' => $errors,
    'note' => $note,
  ]);
}

$db->query('update Note set title = :title, body = :body where id = :id;', [
  'id' => $_POST['id'],
  'title' => $_POST['title'],
  'body' => $_POST['body'],
]);

header('location: /notes');
die();
