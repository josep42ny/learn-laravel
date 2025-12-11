<?php

namespace Http\dao;

use Core\App;
use Core\Database;
use Http\model\Note;

class NoteDaoDbImpl implements NoteDao
{
  public function getAll(int $userId): array
  {
    $db = App::resolve(Database::class);
    $notes = $db->query('select * from Note where userId = :id', ['id' => $userId])->getAll();
    return array_map([$this, 'noteOf'], $notes);
  }

  public function get(int $noteId): Note
  {
    $db = App::resolve(Database::class);
    $note = $db->query('select * from Note where id = :id', [
      'id' => $noteId
    ])->getOrFail();
    return $this->noteOf($note);
  }

  public function delete(int $userId, int $noteId): void
  {
    $db = App::resolve(Database::class);
    $db->query('delete from Note where id = :id and userId = :userId', [
      'id' => $noteId,
      'userId' => $userId
    ]);
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

  public function update(string $title, string $body, int $noteId, int $userId): void
  {
    $db = App::resolve(Database::class);
    $db->query('update Note set title = :title, body = :body where id = :id and userId = :userId', [
      'title' => $title,
      'body' => $body,
      'id' => $noteId,
      'userId' => $userId
    ]);
  }

  private function noteOf($obj): Note
  {
    return new Note(
      $obj['id'],
      $obj['title'],
      $obj['body'],
      $obj['userId']
    );
  }
}
