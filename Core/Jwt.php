<?php

namespace Core;

use Exception;

class Jwt
{
  private static string $key = 'b5566daafc292a46ef3ad2227358611d5f5dba145722043a6fb3e02d893e6a0c';
  public function __construct() {}

  public static function encode(array $payload): string
  {

    $header = json_encode([
      "alg" => "HS256",
      "typ" => "JWT"
    ]);

    $header = static::base64URLEncode($header);
    $payload = json_encode($payload);
    $payload = static::base64URLEncode($payload);

    $signature = hash_hmac("sha256", $header . "." . $payload, static::$key, true);
    $signature = static::base64URLEncode($signature);
    return $header . "." . $payload . "." . $signature;
  }



  public static function decode(string $token): array
  {
    if (
      preg_match(
        "/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/",
        $token,
        $matches
      ) !== 1
    ) {

      throw new Exception("invalid token format");
    }

    $signature = hash_hmac(
      "sha256",
      $matches["header"] . "." . $matches["payload"],
      static::$key,
      true
    );

    $signature_from_token = static::base64URLDecode($matches["signature"]);

    if (!hash_equals($signature, $signature_from_token)) {

      throw new Exception("signature doesn't match");
    }

    $payload = json_decode(static::base64URLDecode($matches["payload"]), true);

    return $payload;
  }


  private static function base64URLEncode(string $text): string
  {

    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
  }

  private static function base64URLDecode(string $text): string
  {
    return base64_decode(
      str_replace(
        ["-", "_"],
        ["+", "/"],
        $text
      )
    );
  }
}
