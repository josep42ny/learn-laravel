<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];
$errors = [];

if (!Validator::email($email)) {
  $errors['email'] = ['Provide a valid email address.'];
}

if (!Validator::string($password)) {
  $errors['password'] = ['Provide a valid password'];
}

if (!empty($errors)) {
  return view('sessions/create.view.php', [
    'errors' => $errors
  ]);
}

$db = App::resolve(Database::class);
$user = $db->query('select * from User where email like :email', [
  'email' => $email
])->get();

if ($user) {
  if (password_verify($password, $user['password'])) {
    login(['email' => $email]);

    header('location: /');
    exit();
  }
}

return view('sessions/create.view.php', [
  'errors' => ['email' => ['No matching account found for given email and password']]
]);
