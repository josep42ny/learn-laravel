<?php

namespace Http\model;

use JsonSerializable;

class Note implements JsonSerializable
{
  public function __construct(
    private int $id,
    private string $title,
    private string $body,
    private int $userId
  ) {}

  public function getId(): int
  {
    return $this->id;
  }
  public function setId($id): void
  {
    $this->id = $id;
  }
  public function getTitle(): string
  {
    return $this->title;
  }
  public function setTitle($title): void
  {
    $this->title = $title;
  }
  public function getBody(): string
  {
    return $this->body;
  }
  public function setBody($body): void
  {
    $this->body = $body;
  }
  public function getUserId(): int
  {
    return $this->userId;
  }
  public function setUserId($userId): void
  {
    $this->userId = $userId;
  }

  public function jsonSerialize(): mixed
  {
    return get_object_vars($this);
  }
}
