<?php

require './Validator.php';

$heading = "Create new note";
$config = require('./config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

  if (!$hasError) {
    $db->query('insert into Note(title, body, userId) values (:title, :body, :uid)', [
      'title' => $_POST['title'],
      'body' => $_POST['body'],
      'uid' => 1
    ]);
  }
}

require "views/notes/create.view.php";
