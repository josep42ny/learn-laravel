<?php

namespace Core\Middleware;

class Api
{
  public function handle()
  {
    if (!isset($_SESSION['user'])) {
      redirect('/login');
    }
  }
}
