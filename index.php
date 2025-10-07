<?php

require 'functions.php';
require 'Database.php';
$config = require 'config.php';
//require 'router.php';

$db = new Database($config['database']);
$post = $db->query('select * from posts where id = 2')->fetch(PDO::FETCH_ASSOC);

echo "<li>{$post['title']}</li>";
