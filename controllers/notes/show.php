<?php

use Core\Database;

$authorisedUser = 1;

$config = require(baseUrl('config.php'));
$db = new Database($config['database']);

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
