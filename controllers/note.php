<?php
$heading = "Note";

$config = require('./config.php');
$db = new Database($config['database']);

$nid = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$note = $db->query(
  'select * from Note where id = :nid',
  [
    'nid' => $nid,
  ],
)->fetch();

if (!$note) {
  abort(HttpResponse::NOT_FOUND);
}

$authorisedUser = 1;

if ($note['userId'] !== $authorisedUser) {
  abort(HttpResponse::FORBIDDEN);
}

require "views/note.view.php";
