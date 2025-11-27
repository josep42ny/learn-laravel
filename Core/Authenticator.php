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
        $this->login(['email' => $email]);

        return true;
      }
    }

    return false;
  }

  public function login($user): void
  {
    $db = App::resolve(Database::class);
    $id = $db->query('select id from User where email like :email', [
      'email' => $user['email']
    ])->get();

    $_SESSION['user'] = [
      'id' => $id,
      'email' => $user['email']
    ];

    session_regenerate_id(true);
  }

  public function logout(): void
  {
    Session::destroy();
  }
}
