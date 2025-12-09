<?php

namespace Http\controllers;

use Core\Validator;
use Http\dao\NoteDao;
use Http\dao\NoteDaoFactory;
use Http\dao\UserDao;
use Http\dao\UserDaoFactory;
use Http\model\User;

class NotesClient
{
  private NoteDao $noteService;
  private UserDao $userService;

  public function __construct()
  {
    $this->noteService = NoteDaoFactory::assemble();
    $this->userService = UserDaoFactory::assemble();
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
      abort(400);
    }

    $validUser = $this->attemptValidateUser();

    $this->respond(
      [
        'notes' => $this->noteService->get($validUser->getId(), $params['id'])
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
      abort(400);
    }

    $validUser = $this->attemptValidateUser();

    $this->noteService->delete($validUser->getId(), $params['id']);
    $this->respond([], 201);
  }

  public function edit($params)
  {
    if (!Validator::integer($params['id'])) {
      abort(400);
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
      abort(403);
    }

    $token = str_replace('Bearer ', '', getallheaders()['Authorization']);
    $users = $this->userService->getAll();

    foreach ($users as $user) {
      if ($user->getToken() == $token) {
        return $user;
      }
    }

    abort(403);
  }
}
