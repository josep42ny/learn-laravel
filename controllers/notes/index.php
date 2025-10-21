<?php

$config = require(baseUrl('config.php'));
$db = new Database($config['database']);

$notes = $db->query('select * from Note where userId = 1')->getAll();

view('notes/index.view.php', [
  'heading' => 'My Notes',
  'notes' => $notes,
]);
