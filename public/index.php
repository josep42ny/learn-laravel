<?php

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'functions.php';

spl_autoload_register(function ($class) {
  require baseUrl('Core/' . $class . '.php');
});

require baseUrl('router.php');
