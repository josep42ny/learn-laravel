<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$authorisedUser = 1;

$note = $db->query('select * from Note where id = :id', [
  'id' => $_POST['id'],
])->getOrFail();

authorise($note['userId'] === $authorisedUser);

$db->query('delete from Note where id = :id', [
  'id' => $note['id'],
]);

redirect('/notes');
