<?php

namespace Core;

class Validator
{
  public static function string($value, $min = 1, $max = INF): bool
  {
    $length = strlen(trim($value));

    return $length >= $min && $length <= $max;
  }
}
