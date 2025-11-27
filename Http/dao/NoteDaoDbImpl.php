<?php

use Core\App;
use Core\Database;

class NoteDaoDbImpl implements NoteDao
{
  public function getAll(int $userId): array
  {
    $db = App::resolve(Database::class);
    return $db->query('select * from Note where userId = :id', ['id' => $userId])->getAll();
  }

  public function get(int $noteId): Note
  {
    $db = App::resolve(Database::class);
    return $db->query('select * from Note where id = :id', ['id' => $noteId])->getOrFail();
  }

  public function delete(int $noteId): void
  {
    $db = App::resolve(Database::class);
    $db->query('delete from Note where id = :noteId', ['id' => $noteId]);
  }

  public function store(string $title, string $body, int $userId): void
  {
    $db = App::resolve(Database::class);
    $db->query('insert into Note(title, body, userId) values (:title, :body, :id)', [
      'title' => $title,
      'body' => $body,
      'id' => $userId
    ]);
  }

  public function update(string $title, string $body, int $noteId): void
  {
    $db = App::resolve(Database::class);
    $db->query('update Note set title = :title, body = :body where id = :id', [
      'title' => $title,
      'body' => $body,
      'id' => $noteId
    ]);
  }
}
