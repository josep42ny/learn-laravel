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
