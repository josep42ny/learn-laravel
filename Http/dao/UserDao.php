<?php

namespace Http\dao;

use Http\model\User;

interface UserDao
{
  public function getAll(): array;
  public function get(int $userId): mixed;
  public function getByEmail(string $email): mixed;
  public function update(int $id, string $email, string $token, string $password): void;
  public function addToken(int $id, string $token): void;
  public function getAllTokens(): array;
  public function deleteToken(string $token): void;
}
