<?php

use Core\Database;
use Core\HttpResponse;

$authorisedUser = 1;

$config = require(baseUrl('config.php'));
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $note = $db->query('select * from Note where id = :id', [
    'id' => $_POST['id'],
  ])->getOrFail();

  authorise($note['userId'] === $authorisedUser);

  $db->query('delete from Note where id = :id', [
    'id' => $note['id'],
  ]);

  header('location: /notes');
  exit();
} else {
  $nid = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  $note = $db->query(
    'select * from Note where id = :nid',
    [
      'nid' => $nid,
    ],
  )->getOrFail();

  authorise($note['userId'] === 1);

  view('notes/show.view.php', [
    'heading' => 'Note',
    'note' => $note,
  ]);
}
