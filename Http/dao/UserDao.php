<?php

namespace Http\dao;

use Http\model\User;

interface UserDao
{
  public function getAll(): array;
  public function get(int $userId): User;
  public function getByEmail(string $email): User;
  public function update(int $id, string $email, string $token, string $password): void;
  public function addToken(int $id, string $token): void;
  public function getAllTokens(): array;
}
