<?php

namespace Http\controllers;

use Core\HttpResponse;
use Core\Validator;
use Http\dao\NoteDao;
use Http\dao\NoteDaoFactory;
use Http\model\Token;
use Http\model\User;
use Http\services\UserService;

class NotesClient
{
  private NoteDao $noteService;
  private UserService $userService;

  public function __construct()
  {
    $this->noteService = NoteDaoFactory::assemble();
    $this->userService = new UserService();
  }

  public function getAll(): void
  {
    $validUser = $this->attemptValidateUser();

    $data = [
      'notes' => $this->noteService->getAll($validUser->getId())
    ];

    $this->respond($data);
  }

  public function getOne(array $params)
  {
    if (!Validator::integer($params['id'])) {
      abort(HttpResponse::BAD_REQUEST);
    }

    $validUser = $this->attemptValidateUser();

    $note = $this->noteService->get($params['id']);
    if ($note->getUserId() != $validUser->getId()) {
      abort(HttpResponse::FORBIDDEN);
    }

    $this->respond(
      [
        'notes' => $note
      ]
    );
  }

  public function store()
  {
    $requestBody = json_decode(file_get_contents('php://input'));
    $validUser = $this->attemptValidateUser();

    $this->noteService->store($requestBody->title, $requestBody->body, $validUser->getId());
    $this->respond([], 201);
  }

  public function destroy($params)
  {
    if (!Validator::integer($params['id'])) {
      abort(HttpResponse::BAD_REQUEST);
    }

    $validUser = $this->attemptValidateUser();

    $this->noteService->delete($validUser->getId(), $params['id']);
    $this->respond([], 201);
  }

  public function edit($params)
  {
    if (!Validator::integer($params['id'])) {
      abort(HttpResponse::BAD_REQUEST);
    }

    $requestBody = json_decode(file_get_contents('php://input'));
    $validUser = $this->attemptValidateUser();

    $this->noteService->update($requestBody->title, $requestBody->body, $params['id'], $validUser->getId());
    $this->respond([], 200);
  }

  private function respond($data, $statusCode = 200): void
  {
    header('Content-Type: application/json');
    http_response_code($statusCode);

    $json = json_encode($data);
    view('api/json.php', ['json' => $json]);
    die();
  }

  private function attemptValidateUser(): User
  {
    if (!array_key_exists('Authorization', getallheaders())) {
      abort(HttpResponse::UNAUTHORIZED);
    }

    $token = str_replace('Bearer ', '', getallheaders()['Authorization']);
    $tokens = $this->userService->getAllTokens();

    foreach ($tokens as $t) {
      if ($t->getValue() == $token) {
        return $this->userService->get($t->getSub());
      }
    }

    abort(HttpResponse::FORBIDDEN);
  }
}
