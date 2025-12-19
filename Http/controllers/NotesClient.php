<?php

namespace Http\controllers;

use Core\HttpResponse;
use Core\Validator;
use Core\View;
use Http\dao\NoteDao;
use Http\dao\NoteDaoFactory;
use Http\model\Note;
use Http\services\UserService;

class NotesClient
{
  private NoteDao $noteDao;
  private UserService $userService;

  public function __construct()
  {
    $this->noteDao = NoteDaoFactory::assemble();
    $this->userService = new UserService();
  }

  public function getAll(): void
  {
    $userId = $this->validateUser();

    $this->respond(
      [
        'notes' => $this->noteDao->getAll($userId)
      ]
    );
  }

  public function getOne(array $params)
  {
    $noteId = $params['id'];
    if (!Validator::integer($noteId)) {
      abort(HttpResponse::BAD_REQUEST);
    }

    $userId = $this->validateUser();

    $note = $this->validateOwnership($noteId, $userId);

    $this->respond(
      [
        'notes' => $note
      ]
    );
  }

  public function store()
  {
    $requestBody = json_decode(file_get_contents('php://input'));

    if (!isset($requestBody) || !Validator::objectFieldsAre($requestBody, ['title', 'body'])) {
      abort(HttpResponse::BAD_REQUEST);
    };

    $userId = $this->validateUser();

    $this->noteDao->store(new Note(
      -1,
      $requestBody->title,
      $requestBody->body,
      $userId
    ));

    $this->respond(
      []
    );
  }

  public function destroy($params)
  {
    $noteId = $params['id'];
    if (!Validator::integer($noteId)) {
      abort(HttpResponse::BAD_REQUEST);
    }

    $userId = $this->validateUser();

    $this->validateOwnership($noteId, $userId);

    $this->noteDao->delete($noteId);
    $this->respondNoPayload();
  }

  public function edit($params)
  {
    $noteId = $params['id'];
    if (!Validator::integer($noteId)) {
      abort(HttpResponse::BAD_REQUEST);
    }

    $requestBody = json_decode(file_get_contents('php://input'));
    if (!isset($requestBody) || !Validator::objectFieldsHave($requestBody, ['body', 'title'])) {
      View::abortJson(HttpResponse::BAD_REQUEST);
    };

    $userId = $this->validateUser();
    $note = $this->validateOwnership($noteId, $userId);

    $this->noteDao->update(new Note(
      $noteId,
      $requestBody->title ?? $note->getTitle(),
      $requestBody->body ?? $note->getBody(),
      -1
    ));
    $this->respondNoPayload();
  }

  private function respond(array $data, HttpResponse $statusCode = HttpResponse::OK): void
  {
    http_response_code($statusCode->value);

    $json = json_encode($data);
    View::html('api/json.php', ['json' => $json]);
    die();
  }

  private function respondNoPayload(HttpResponse $statusCode = HttpResponse::NO_CONTENT): void
  {
    http_response_code($statusCode->value);
    die();
  }

  private function validateOwnership(int $noteId, int $userId): Note
  {
    $note = $this->noteDao->get($noteId);

    if ($note->getUserId() != $userId) {
      abort(HttpResponse::FORBIDDEN);
    }

    return $note;
  }

  private function validateUser(): int
  {
    if (!array_key_exists('Authorization', getallheaders())) {
      abort(HttpResponse::UNAUTHORIZED);
    }

    $headerToken = str_replace('Bearer ', '', getallheaders()['Authorization']);
    $tokens = $this->userService->getAllTokens();

    foreach ($tokens as $token) {
      if ($token->getValue() == $headerToken && $token->getExpiration() >= time()) {
        return $this->userService->get($token->getSub())->getId();
      }
    }

    View::abortJson(HttpResponse::FORBIDDEN);
  }
}
