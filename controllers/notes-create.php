<?php
$heading = "Create new note";

$config = require('./config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //dd($_POST);
  $db->query('insert into Note(title, body, userId) values (:title, :body, :uid)', [
    'title' => $_POST['title'],
    'body' => $_POST['body'],
    'uid' => 1
  ]);
}

require "views/notes-create.view.php";
