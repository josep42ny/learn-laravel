<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm
{
  private $errors = [];

  public function validate($email, $password): bool
  {
    if (!Validator::email($email)) {
      $this->errors['email'] = ['Provide a valid email address.'];
    }

    if (!Validator::string($password)) {
      $this->errors['password'] = ['Provide a valid password'];
    }

    return empty($this->errors);
  }

  public function errors(): array
  {
    return $this->errors;
  }
}
