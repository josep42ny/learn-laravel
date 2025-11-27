<?php

use Core\Authenticator;
use Http\Forms\LoginForm;

$parameters = [
  'email' => $_POST['email'],
  'password' => $_POST['password']
];
$form = LoginForm::validate($parameters);
$singedIn = (new Authenticator)->attempt($parameters['email'], $parameters['password']);

if (!$singedIn) {
  $form->addError('email', ['No matching account found for given email and password'])
    ->throw();
}

redirect('/');
