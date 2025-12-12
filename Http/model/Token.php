<?php

namespace Http\model;

class Token
{
  public function __construct(
    private string $value,
    private int $sub,
    private int $iat,
    private int $expiration
  ) {}

  public function getValue(): string
  {
    return $this->value;
  }
  public function setValue($value): void
  {
    $this->value = $value;
  }
  public function getSub(): int
  {
    return $this->sub;
  }
  public function setSub($sub): void
  {
    $this->sub = $sub;
  }
  public function getIat(): int
  {
    return $this->iat;
  }
  public function setIat($iat): void
  {
    $this->iat = $iat;
  }
}
