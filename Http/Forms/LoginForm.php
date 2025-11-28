<?php

namespace Http\Forms;

use Core\ValidationException;
use Core\Validator;

class LoginForm
{
  private $errors = [];

  public function __construct(public array $parameters)
  {
    if (!Validator::email($parameters['email'])) {
      $this->errors['email'] = ['Provide a valid email address.'];
    }

    if (!Validator::string($parameters['password'], 8)) {
      $this->errors['password'] = ['Provide a valid password'];
    }

    //return empty($this->errors);
  }

  public static function validate($parameters)
  {
    $instance = new static($parameters);

    return $instance->failed() ? $instance->throw() : $instance;
  }

  public function throw()
  {
    ValidationException::throw($this->errors, $this->parameters);
  }

  private function failed(): bool
  {
    return count($this->errors);
  }

  public function errors(): array
  {
    return $this->errors;
  }

  public function addError($field, $message): LoginForm
  {
    $this->errors[$field] = $message;

    return $this;
  }
}
