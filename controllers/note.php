<?php
$heading = "Note";

$config = require('./config.php');
$db = new Database($config['database']);

$uid = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$note = $db->query(
  'select * from Note where id = :uid',
  [
    'uid' => $uid,
  ],
)->fetch();

require "views/note.view.php";
