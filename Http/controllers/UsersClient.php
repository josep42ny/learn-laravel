<?php

namespace Http\Controllers;

use Core\Authenticator;
use Core\HttpResponse;
use Core\Validator;
use Http\model\User;
use Http\services\UserService;

class UsersClient
{
  private UserService $userService;

  public function __construct()
  {
    $this->userService = new UserService();
  }

  public function getToken()
  {
    $requestBody = json_decode(file_get_contents('php://input'));

    if (!isset($requestBody) || !Validator::objectFieldsAre($requestBody, ['email', 'password'])) {
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
    $this->validateUser();

    $token = str_replace('Bearer ', '', getallheaders()['Authorization']);
    $this->userService->deleteToken($token);

    http_response_code(HttpResponse::NO_CONTENT->value);
    die();
  }

  public function edit(): void
  {
    $requestBody = json_decode(file_get_contents('php://input'));


    if (!isset($requestBody) || !Validator::objectFieldsHave($requestBody, ['username', 'picture'])) {
      abort(HttpResponse::BAD_REQUEST);
    };
    dd($requestBody);

    $userId = $this->validateUser();

    $this->userService->edit([]);
  }

  private function respond(array $data, HttpResponse $statusCode = HttpResponse::OK): void
  {
    http_response_code($statusCode->value);

    $json = json_encode($data);
    view('api/json.php', ['json' => $json]);
    die();
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
