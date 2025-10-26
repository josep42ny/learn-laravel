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

view('notes/edit.view.php', [
  'heading' => 'Edit note',
  'errors' => [],
  'note' => $note,
]);

/*
    <form action="#" method="post" class="mt-6">
      <input type="hidden" name="_method" value="DELETE">
      <input type="hidden" name="id" value="<?= $note['id'] ?>">
      <button type="submit" class="text-sm text-red-500">Delete</button>
    </form>
*/