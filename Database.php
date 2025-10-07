<?php

class Database
{
  private PDO $pdo;

  public function __construct($config, $user = 'root', $password = 'mariadb')
  {
    $dsn = 'mysql:' . http_build_query($config, '', ';');
    $this->pdo = new PDO($dsn, $user, $password, [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }

  public function query($query, $params = []): PDOStatement
  {
    $statement = $this->pdo->prepare($query);
    $statement->execute($params);

    return $statement;
  }
}
