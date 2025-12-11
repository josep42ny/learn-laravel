<?php

namespace Http\model;

class Token
{
  public function __construct(
    private int $value,
    private string $sub,
    private string $iat
  ) {}

  public function getValue(): int
  {
    return $this->value;
  }
  public function setValue($value): void
  {
    $this->value = $value;
  }
  public function getSub(): string
  {
    return $this->sub;
  }
  public function setSub($sub): void
  {
    $this->sub = $sub;
  }
  public function getIat(): string
  {
    return $this->iat;
  }
  public function setIat($iat): void
  {
    $this->iat = $iat;
  }
}
