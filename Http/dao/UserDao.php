<?php

namespace Http\dao;

use Http\model\User;

interface UserDao
{
  public function getAll(): array;
  public function get(int $noteId): User;
  public function update(int $id, string $email, string $token, string $password): void;
}
