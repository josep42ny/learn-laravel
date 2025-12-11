<?php

namespace Http\Controllers;

use Core\Authenticator;
use Core\HttpResponse;
use Core\Validator;
use Http\dao\NoteDao;
use Http\dao\NoteDaoFactory;
use Http\model\User;
use Http\services\UserService;

class UsersClient
{
  private NoteDao $noteDao;
  private UserService $userService;

  public function __construct()
  {
    $this->noteDao = NoteDaoFactory::assemble();
    $this->userService = new UserService();
  }

  public function getToken()
  {
    $requestBody = json_decode(file_get_contents('php://input'));

    if (!isset($requestBody) || !Validator::objectFields($requestBody, ["email", "password"])) {
      abort(HttpResponse::BAD_REQUEST);
    };

    if (!(new Authenticator())->attempt($requestBody->email, $requestBody->password)) {
      abort(HttpResponse::FORBIDDEN);
    };

    $token = $this->userService->addToken($requestBody->email);

    $this->respond(['token' => $token]);
  }

  private function respond(array $data, HttpResponse $statusCode = HttpResponse::OK): void
  {
    header('Content-Type: application/json');
    http_response_code($statusCode->value);

    $json = json_encode($data);
    view('api/json.php', ['json' => $json]);
    die();
  }

  private function attemptValidateUser(): User
  {
    if (!array_key_exists('Authorization', getallheaders())) {
      abort(HttpResponse::FORBIDDEN);
    }

    $token = str_replace('Bearer ', '', getallheaders()['Authorization']);
    $users = $this->userService->getAll();

    foreach ($users as $user) {
      if ($user->getToken() == $token) {
        return $user;
      }
    }

    abort(HttpResponse::FORBIDDEN);
  }
}
