<?php

namespace Core\Middleware;

class Api
{
  public function handle()
  {
    $requestingJson = array_key_exists('Content-Type', getallheaders()) && getallheaders()['Content-Type'] == 'application/json';

    if (!$requestingJson) {
      redirect('/');
    }

    header('Content-Type: application/json');
  }
}
