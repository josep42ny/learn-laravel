<?php

namespace Http\services;

use Core\Jwt;
use Http\dao\UserDao;
use Http\dao\UserDaoFactory;
use Http\model\Token;
use Http\model\User;

class UserService
{

  private UserDao $userDao;

  public function __construct()
  {
    $this->userDao = UserDaoFactory::assemble();
  }

  public function get(int $id): User
  {
    $rawUser = $this->userDao->get($id);
    return $this->userOf($rawUser);
  }

  public function getByEmail(string $email): User
  {
    $rawUser = $this->userDao->getByEmail($email);
    return $this->userOf($rawUser);
  }

  public function getAll(): array
  {
    $rawUsers = $this->userDao->getAll();
    return array_map([$this, 'userOf'], $rawUsers);
  }

  public function addToken(string $email): string
  {
    $id = $this->getByEmail($email)->getId();
    $token = Jwt::encode(['sub' => $id, 'iat' => time()]);

    $DAYS_UNIX = 7 * 24 * 60 * 60;
    $EXPIRY_DATE_UNIX = time() + $DAYS_UNIX;
    $this->userDao->addToken($id, $token, $EXPIRY_DATE_UNIX);
    return $token;
  }

  public function getAllTokens(): array
  {
    $rawTokens = $this->userDao->getAllTokens();
    return array_map([$this, 'tokenOf'], $rawTokens);
  }

  public function deleteToken(string $token): void
  {
    $this->userDao->deleteToken($token);
  }

  public function deleteAllTokens(string $token): void
  {
    $userId = Jwt::decode($token)['sub'];
    $this->userDao->deleteAllTokens($userId);
  }

  public function edit(int $userId, string | null $username, string | null $picture): void
  {
    $user = $this->get($userId);

    $user->setUsername($username ?? $user->getUsername());
    $user->setPicture($picture ?? $user->getPicture());

    $this->userDao->update($user);
  }

  // public function edit(int $userId, array $fields): void
  // {
  //   $user = $this->get($userId);
  //   $userFields = get_object_vars($user);
  //   foreach ($fields as $field) {
  //     if (array_key_exists($userFields, $field)) {

  //     }
  //   }
  //   //$this->userDao->update();
  // }

  private function userOf(mixed $obj): User
  {
    return new User(
      $obj['id'],
      $obj['email'],
      $obj['username'],
      $obj['picture'] ?? null,
      $obj['password']
    );
  }

  private function tokenOf(array $rawToken): Token
  {
    $token = Jwt::decode($rawToken['value']);

    return new Token(
      $rawToken['value'],
      $token['sub'],
      $token['iat'],
      $rawToken['expiration']
    );
  }
}
