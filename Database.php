<?php

class Database
{
  private string $prefix = 'mysql';
  private string $host = '127.0.0.1';
  private string $port = '3306';
  private string $dbname = 'myapp';
  private string $charset = 'latin1';
  private string $user = 'root';
  private string $password = 'mariadb';
  private PDO $pdo;

  public function __construct()
  {
    $dsn = "{$this->prefix}:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset}";
    $this->pdo = new PDO($dsn, $this->user, $this->password);
  }

  public function query($query): PDOStatement
  {
    $statement = $this->pdo->prepare($query);
    $statement->execute();

    return $statement;
  }
}
