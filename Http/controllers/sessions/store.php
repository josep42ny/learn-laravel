<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Http\Forms\LoginForm;

$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();
if (!$form->validate($email, $password)) {
  return view('sessions/login', [
    'errors' => $form->errors()
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
