<?php

function dd($var)
{
  echo '
<pre>';
  var_dump($var);
  echo '</pre>';
  die();
}

function uriIs($var)
{
  return $_SERVER['REQUEST_URI'] === $var;
}

function abort($statusCode = 404)
{
  http_response_code(404);
  require "views/{$statusCode}.php";
  die();
}
function routeToController($url, $routes)
{
  if (array_key_exists($url, $routes)) {
    require $routes[$url];
  } else {
    abort();
  }
}
