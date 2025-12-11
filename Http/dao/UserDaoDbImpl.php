<?php

namespace Http\dao;

use Core\App;
use Core\Database;
use Core\Jwt;
use Http\model\Note;
use Http\model\Token;
use Http\model\User;

class UserDaoDbImpl implements UserDao
{
  public function getAll(): array
  {
    $db = App::resolve(Database::class);
    $users = $db->query('select * from User')->getAll();
    return array_map([$this, 'userOf'], $users);
  }

  public function get(int $userId): User
  {
    $db = App::resolve(Database::class);
    $user = $db->query('select * from User where id = :id', ['id' => $userId])->getOrFail();
    return $this->userOf($user);
  }

  public function getByEmail(string $email): User
  {
    $db = App::resolve(Database::class);
    $user = $db->query('select * from User where email = :email', ['email' => $email])->getOrFail();
    return $this->userOf($user);
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

  public function addToken(int $id, string $token): void
  {
    $db = App::resolve(Database::class);
    $db->query('insert into Token (value, userId) values (:token, :id)', [
      'id' => $id,
      'token' => $token
    ]);
  }

  public function getAllTokens(): array
  {
    $db = App::resolve(Database::class);
    $tokens = $db->query('select * from Token')->getAll();
    return array_map([$this, 'tokenOf'], $tokens);
  }

  private function userOf($obj): User
  {
    return new User(
      $obj['id'],
      $obj['email'],
      $obj['password']
    );
  }

  private function tokenOf($obj): Token
  {
    $rawToken = Jwt::decode($obj['value']);
    dd($obj);
    return new Token(
      $obj['value'],
      $rawToken['sub'],
      $rawToken['iat']
    );
  }
}
