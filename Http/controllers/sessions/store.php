<?php

use Core\Authenticator;
use Core\Session;
use Http\Forms\LoginForm;


$email = $_POST['email'];
$password = $_POST['password'];
$form = new LoginForm();

if ($form->validate($email, $password)) {
  if ((new Authenticator)->attempt($email, $password)) {
    redirect('/');
  }

  $form->addError('email', ['No matching account found for given email and password']);
}

Session::flash('errors', $form->errors());

redirect('/login');
