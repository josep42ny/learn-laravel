<?php

namespace Http\dao;

use Core\App;
use Core\Database;
use Http\model\User;

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

  public function update(User $user): void
  {
    $db = App::resolve(Database::class);
    $db->query('update User set email = :email, username = :username, picture = :picture, password = :password where id = :id', [
      'id' => $user->getId(),
      'email' => $user->getEmail(),
      'username' => $user->getUsername(),
      'picture' => $user->getPicture(),
      'password' => $user->getPassword()
    ]);
  }

  public function addToken(int $userId, string $token, int $expiration): void
  {
    $db = App::resolve(Database::class);
    $db->query('insert into Token (value, userId, expiration) values (:token, :id, :expiration)', [
      'id' => $userId,
      'token' => $token,
      'expiration' => $expiration
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
