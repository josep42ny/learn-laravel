<?php

use Core\HttpResponse;

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

function abort(HttpResponse $statusCode = HttpResponse::NOT_FOUND)
{
  http_response_code($statusCode->value);
  require baseUrl("views/{$statusCode->value}.php");
  die();
}

function authorise($criteria, $response = HttpResponse::FORBIDDEN): void
{
  if (!$criteria) {
    abort($response);
  }
}

function baseUrl($path): string
{
  return BASE_PATH . $path;
}

function view($path, $attributes = []): void
{
  extract($attributes);
  require baseUrl('views/' . $path);
}

function redirect($path): void
{
  header("location: {$path}");
  exit();
}

function old($key): mixed
{
  return Core\Session::get('old')[$key] ?? '';
}
