<?php

use Core\Session;

View::html('sessions/create.view.php', [
  'errors' => Session::get('errors', [])
]);
