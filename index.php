<?php

require 'functions.php';
require 'Database.php';
//require 'router.php';

$config = [
  'host' => '127.0.0.1',
  'port' => '3306',
  'dbname' => 'myapp',
  'charset' => 'latin1',
];
$db = new Database($config);
$post = $db->query('select * from posts where id = 2')->fetch(PDO::FETCH_ASSOC);

echo "<li>{$post['title']}</li>";
