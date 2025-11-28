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
        $this->login(['id' => $user['id'], 'email' => $email]);

        return true;
      }
    }

    return false;
  }

  public function login($user): void
  {
    $_SESSION['user'] = [
      'id' => $user['id'],
      'email' => $user['email']
    ];

    session_regenerate_id(true);
  }

  public function logout(): void
  {
    Session::destroy();
  }
}
