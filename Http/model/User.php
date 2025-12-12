<?php

namespace Http\model;

class User
{
  public function __construct(
    private int $id,
    private string $email,
    private string $username,
    private string $picture,
    private string $password
  ) {}

  public function getId(): int
  {
    return $this->id;
  }
  public function setId(int $id): void
  {
    $this->id = $id;
  }
  public function getEmail(): string
  {
    return $this->email;
  }
  public function setEmail(string $email): void
  {
    $this->email = $email;
  }
  public function getUsername(): string
  {
    return $this->username;
  }
  public function setUsername(string $username): void
  {
    $this->username = $username;
  }
  public function getPicture(): string
  {
    return $this->picture;
  }
  public function setPicture(string $picture): void
  {
    $this->picture = $picture;
  }
  public function getPassword(): string
  {
    return $this->password;
  }
  public function setPassword(string $password): void
  {
    $this->password = $password;
  }
}
