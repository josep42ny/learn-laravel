<?php

namespace Http\model;

class User
{
  public function __construct(
    private int $id,
    private string $email,
    private string $token,
    private string $password
  ) {}

  public function getId(): int
  {
    return $this->id;
  }
  public function setId($id): void
  {
    $this->id = $id;
  }
  public function getEmail(): string
  {
    return $this->email;
  }
  public function setEmail($email): void
  {
    $this->email = $email;
  }
  public function getToken(): string
  {
    return $this->token;
  }
  public function setToken($token): void
  {
    $this->token = $token;
  }
  public function getPassword(): string
  {
    return $this->password;
  }
  public function setPassword($password): void
  {
    $this->password = $password;
  }
}
