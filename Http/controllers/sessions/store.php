<?php

use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\Validator;
use Http\Forms\LoginForm;

$email = $_POST['email'];
$password = $_POST['password'];
$form = new LoginForm();

if ($form->validate($email, $password)) {
  if ((new Authenticator)->attempt($email, $password)) {
    redirect('/');
  }
}

$form->errors('email', ['No matching account found for given email and password']);

return view('sessions/create.view.php', [
  'errors' => $form->errors()
]);
