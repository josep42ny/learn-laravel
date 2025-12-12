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

  public function deleteCurrentToken()
  {
    $this->validateUser();

    $token = str_replace('Bearer ', '', getallheaders()['Authorization']);
    $this->userService->deleteToken($token);

    $this->respondNoPayload();
  }

  public function deleteAllTokens()
  {
    $this->validateUser();

    $token = str_replace('Bearer ', '', getallheaders()['Authorization']);
    $this->userService->deleteAllTokens($token);

    $this->respondNoPayload();
  }

  public function edit(): void
  {
    $requestBody = json_decode(file_get_contents('php://input'));


    if (!isset($requestBody) || !Validator::objectFieldsHave($requestBody, ['username', 'picture'])) {
      abort(HttpResponse::BAD_REQUEST);
    };

    $userId = $this->validateUser();

    $this->userService->edit($userId,  $requestBody->username, $requestBody->picture ?? null);
    $this->respondNoPayload();
  }

  private function respond(array $data, HttpResponse $statusCode = HttpResponse::OK): void
  {
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

    abort(HttpResponse::FORBIDDEN);
  }
}
