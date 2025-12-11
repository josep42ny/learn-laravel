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

  public function delete(int $noteId): void
  {
    $db = App::resolve(Database::class);
    $db->query('delete from Note where id = :id', [
      'id' => $noteId
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

  public function update(string | null $title, string | null $body, int $noteId): void
  {
    if (!isset($title) && !isset($body)) {
      return;
    }

    $db = App::resolve(Database::class);
    if (isset($title) && !isset($body)) {
      $db->query('update Note set body = :title where id = :id', ['title' => $title, 'id' => $noteId]);
      return;
    }

    if (!isset($title) && isset($body)) {
      $db->query('update Note set body = :body where id = :id', ['body' => $body, 'id' => $noteId]);
      return;
    }

    $db->query('update Note set title = :title, body = :body where id = :id', [
      'title' => $title,
      'body' => $body,
      'id' => $noteId
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
