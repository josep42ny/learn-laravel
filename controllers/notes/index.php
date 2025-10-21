<?php
$heading = "My Notes";

$config = require('./config.php');
$db = new Database($config['database']);

$notes = $db->query('select * from Note where userId = 1')->getAll();

require "views/notes/index.view.php";
