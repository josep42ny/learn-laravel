<?php

namespace Core;

class View
{
  private static array $jsonErrors = [
    '400' => 'Malformed request syntax.',
    '401' => 'You are not authorised to view this page.',
    '403' => 'You are forbidden to view this page.',
    '404' => 'Resource not found.',
  ];

  public static function html($path, $attributes = []): void
  {
    extract($attributes);
    require baseUrl('views/' . $path);
  }

  public static function json($attributes = []): void
  {
    extract($attributes);
    require baseUrl('views/api/json.php');
  }

  public static function abortJson(HttpResponse $statusCode = HttpResponse::NOT_FOUND)
  {
    http_response_code($statusCode->value);
    self::json([
      'json' => json_encode([
        'code' => $statusCode->value,
        'text' => self::$jsonErrors[$statusCode->value]
      ])
    ]);
    die();
  }
}
