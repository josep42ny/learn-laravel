<?php

namespace Http\controllers;

use Core\HttpResponse;
use Core\Validator;
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

    if (!isset($requestBody) || !Validator::objectFields($requestBody, ['title', 'body'])) {
      abort(HttpResponse::BAD_REQUEST);
    };

    $userId = $this->validateUser();

    $this->noteDao->store($requestBody->title, $requestBody->body, $userId);
    $this->respond(
      []
    );
  }

  public function destroy($params)
  {
    if (!Validator::integer($params['id'])) {
      abort(HttpResponse::BAD_REQUEST);
    }

    $userId = $this->validateUser();

    $this->validateOwnership($params['id'], $userId);

    $this->noteDao->delete($userId);
    $this->respondNoPayload();
  }

  public function edit($params)
  {
    if (!Validator::integer($params['id'])) {
      abort(HttpResponse::BAD_REQUEST);
    }

    $requestBody = json_decode(file_get_contents('php://input'));
    $userId = $this->validateUser();

    $this->validateOwnership($params['id'], $userId);

    $this->noteDao->update($requestBody->title, $requestBody->body, $params['id']);
    $this->respondNoPayload();
  }

  private function respond(array $data, HttpResponse $statusCode = HttpResponse::OK): void
  {
    header('Content-Type: application/json');
    http_response_code($statusCode->value);

    $json = json_encode($data);
    view('api/json.php', ['json' => $json]);
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

    $token = str_replace('Bearer ', '', getallheaders()['Authorization']);
    $tokens = $this->userService->getAllTokens();

    foreach ($tokens as $t) {
      if ($t->getValue() == $token) {
        return $this->userService->get($t->getSub())->getId();
      }
    }

    abort(HttpResponse::FORBIDDEN);
  }
}
