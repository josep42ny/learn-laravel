<?php

namespace Http\dao;

use Http\model\Note;

interface NoteDao
{
  public function getAll(int $userId): array;
  public function get(int $userId, int $noteId): Note;
  public function delete(int $userId, int $noteId): void;
  public function store(string $title, string $body, int $userId): void;
  public function update(string $title, string $body, int $noteId, int $userId): void;
}
