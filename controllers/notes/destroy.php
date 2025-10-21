<?php

use Core\Database;

$authorisedUser = 1;

$config = require(baseUrl('config.php'));
$db = new Database($config['database']);

$note = $db->query('select * from Note where id = :id', [
  'id' => $_POST['id'],
])->getOrFail();

authorise($note['userId'] === $authorisedUser);

$db->query('delete from Note where id = :id', [
  'id' => $note['id'],
]);

header('location: /notes');
exit();
