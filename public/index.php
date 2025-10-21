<?php

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'Core/functions.php';

spl_autoload_register(function ($class) {
  $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
  require baseUrl($class . '.php');
});

require baseUrl('Core/router.php');
