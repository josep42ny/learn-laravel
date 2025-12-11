<?php

namespace Http\services;

use Core\Jwt;
use Http\dao\UserDao;
use Http\dao\UserDaoFactory;
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
    return $this->userDao->get($id);
  }

  public function getByEmail(string $email): User
  {
    return $this->userDao->getByEmail($email);
  }

  public function getAll(): array
  {
    return $this->userDao->getAll();
  }

  public function addToken(string $email): string
  {
    $id = $this->getByEmail($email)->getId();
    $token = Jwt::encode(['sub' => $id, 'iat' => time()]);

    $this->userDao->addToken($id, $token);
    return $token;
  }

  public function getAllTokens(): array
  {
    return $this->userDao->getAllTokens();
  }
}
