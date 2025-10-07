<?php

require 'functions.php';
//require 'router.php';

$prefix = 'mysql';
$host = '127.0.0.1';
$port = '3306';
$dbname = 'myapp';
$charset = 'latin1';
$user = 'root';
$password = 'mariadb';

$dsn = "{$prefix}:host={$host};port={$port};dbname={$dbname};charset={$charset}";
$pdo = new PDO($dsn, $user, $password);

$statement = $pdo->prepare('select * from posts');
$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {
  echo "<li>{$post['title']}</li>";
}
