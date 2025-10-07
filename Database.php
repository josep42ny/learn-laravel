<?php

class Database
{
  private string $user = 'root';
  private string $password = 'mariadb';
  private PDO $pdo;

  public function __construct($config)
  {
    $dsn = 'mysql:' . http_build_query($config, '', ';');
    $this->pdo = new PDO($dsn, $this->user, $this->password, [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }

  public function query($query): PDOStatement
  {
    $statement = $this->pdo->prepare($query);
    $statement->execute();

    return $statement;
  }
}
