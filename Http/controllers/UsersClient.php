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

  public function deleteToken()
  {
    $this->attemptValidateUser();

    $token = str_replace('Bearer ', '', getallheaders()['Authorization']);
    $this->userService->deleteToken($token);

    http_response_code(HttpResponse::NO_CONTENT->value);
    die();
  }

  private function respond(array | null $data, HttpResponse $statusCode = HttpResponse::OK): void
  {
    http_response_code($statusCode->value);

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
