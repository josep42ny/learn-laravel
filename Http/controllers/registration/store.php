<?php

use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\Jwt;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];
$errors = [];

if (!Validator::email($email)) {
  $errors['email'] = ['Provide a valid email address.'];
}

if (!Validator::string($password, 8, 255)) {
  $errors['password'] = ['Password must be between 8 and 255 characters long'];
}

if (!empty($errors)) {
  return view('registration/create.view.php', [
    'errors' => $errors
  ]);
}

$db = App::resolve(Database::class);
$user = $db->query('select * from User where email like :email', [
  'email' => $email
])->get();

if (!$user) {
  $db->query('insert into User (email, username, password) values (:email, :email, :password)', [
    'email' => $email,
    'password' => password_hash($password, PASSWORD_BCRYPT)
  ]);

  (new Authenticator)->attempt($email, $password);
}

redirect('/');
