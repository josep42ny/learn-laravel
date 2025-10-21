<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$notes = $db->query('select * from Note where userId = 1')->getAll();

view('notes/index.view.php', [
  'heading' => 'My Notes',
  'notes' => $notes,
]);
