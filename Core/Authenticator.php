<?php

namespace Core;

class Authenticator
{
  public function attempt($email, $password): bool
  {
    $db = App::resolve(Database::class);
    $user = $db->query('select * from User where email like :email', [
      'email' => $email
    ])->get();

    if ($user) {
      if (password_verify($password, $user['password'])) {
        $this->login(['id' => $user['id'], 'email' => $user['email'], 'picture' => $user['picture']]);

        return true;
      }
    }

    return false;
  }

  public function login($user): void
  {
    Session::put('user', [
      'id' => $user['id'],
      'email' => $user['email'],
      'picture' => $user['picture']
    ]);

    session_regenerate_id(true);
  }

  public function logout(): void
  {
    Session::destroy();
  }
}
