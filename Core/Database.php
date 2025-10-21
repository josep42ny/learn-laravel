<?php

namespace Core;

use PDO;
use PDOStatement;

class Database
{
  private PDO $pdo;
  private PDOStatement $statement;

  public function __construct($config, $user = 'root', $password = 'mariadb')
  {
    $dsn = 'mysql:' . http_build_query($config, '', ';');
    $this->pdo = new PDO($dsn, $user, $password, [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }

  public function query($query, $params = []): Database
  {
    $this->statement = $this->pdo->prepare($query);
    $this->statement->execute($params);

    return $this;
  }

  public function get(): mixed
  {
    return $this->statement->fetch();
  }

  public function getAll(): mixed
  {
    return $this->statement->fetchAll();
  }

  public function getOrFail(): mixed
  {
    $result = $this->get();

    if (!$result) {
      abort(HttpResponse::NOT_FOUND);
    }

    return $result;
  }
}
