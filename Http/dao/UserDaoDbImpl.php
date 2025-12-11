<?php

namespace Http\dao;

use Core\App;
use Core\Database;

class UserDaoDbImpl implements UserDao
{
  public function getAll(): array
  {
    $db = App::resolve(Database::class);
    $rawUsers = $db->query('select * from User')->getAll();
    return $rawUsers;
  }

  public function get(int $userId): mixed
  {
    $db = App::resolve(Database::class);
    $rawUser = $db->query('select * from User where id = :id', ['id' => $userId])->getOrFail();
    return $rawUser;
  }

  public function getByEmail(string $email): mixed
  {
    $db = App::resolve(Database::class);
    $rawUser = $db->query('select * from User where email = :email', ['email' => $email])->getOrFail();
    return $rawUser;
  }

  public function update(int $id, string $email, string $token, string $password): void
  {
    $db = App::resolve(Database::class);
    $db->query('update User set email = :email, token = :token, password = :password where id = :id', [
      'id' => $id,
      'email' => $email,
      'token' => $token,
      'password' => $password
    ]);
  }

  public function addToken(int $userId, string $token): void
  {
    $db = App::resolve(Database::class);
    $db->query('insert into Token (value, userId) values (:token, :id)', [
      'id' => $userId,
      'token' => $token
    ]);
  }

  public function getAllTokens(): array
  {
    $db = App::resolve(Database::class);
    $rawTokens = $db->query('select * from Token')->getAll();
    return $rawTokens;
  }

  public function deleteToken(string $token): void
  {
    $db = App::resolve(Database::class);
    $db->query('delete from Token where value = :token', [
      'token' => $token
    ]);
  }
}
