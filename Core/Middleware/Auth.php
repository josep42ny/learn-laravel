<?php

namespace Core\Middleware;

use Core\Authenticator;
use Core\Session;
use Http\services\UserService;

class Auth
{
  public function handle()
  {
    if (!Session::has('user')) {
      redirect('/login');
    }
  }
}
