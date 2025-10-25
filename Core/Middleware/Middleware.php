<?php

namespace Core\Middleware;

class Middleware
{

  private const MAP = [
    'guest' => Guest::class,
    'auth' => Auth::class
  ];

  public static function resolve($key)
  {
    if (!$key) {
      return null;
    }

    if (!isset(self::MAP[$key])) {
      throw new \Exception("No matching middleware found for key '{$key}'.");
    }

    $middleware = self::MAP[$key];
    (new $middleware())->handle();
  }
}
