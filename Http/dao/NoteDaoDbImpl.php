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

  public function store(Note $note): void
  {
    $db = App::resolve(Database::class);
    $db->query('insert into Note(title, body, userId) values (:title, :body, :userId)', [
      'title' => $note->getTitle(),
      'body' => $note->getBody(),
      'userId' => $note->getUserId()
    ]);
  }

  public function update(Note $note): void
  {
    $db = App::resolve(Database::class);
    $db->query('update Note set title = :title, body = :body where id = :id', [
      'id' => $note->getId(),
      'title' => $note->getTitle(),
      'body' => $note->getBody()
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
