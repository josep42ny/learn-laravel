<?php
$heading = "Note";
$authorisedUser = 1;

$config = require('./config.php');
$db = new Database($config['database']);

$nid = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$note = $db->query(
  'select * from Note where id = :nid',
  [
    'nid' => $nid,
  ],
)->getOrFail();

authorise($note['userId'] === 1);

require "views/note.view.php";
