<?php

namespace Http\dao;

use Http\model\Note;

interface NoteDao
{
  public function getAll(int $userId): array;
  public function get(int $noteId): Note;
  public function delete(int $noteId): void;
  public function store(Note $note): void;
  public function update(Note $note): void;
}
