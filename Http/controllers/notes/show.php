<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$authorisedUser = 1;

$nid = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$note = $db->query(
  'select * from Note where id = :nid',
  [
    'nid' => $nid,
  ],
)->getOrFail();

authorise($note['userId'] === $authorisedUser);

view('notes/show.view.php', [
  'heading' => 'Note',
  'note' => $note,
]);
