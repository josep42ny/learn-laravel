<?php

require 'functions.php';
require 'Database.php';
$config = require 'config.php';
//require 'router.php';

$db = new Database($config['database']);

$query = 'select * from posts where id = :id';
$params = [
  ':id' => $_GET['id'],
];
$post = $db->query($query, $params)->fetch();

echo "<li>{$post['title']}</li>";
