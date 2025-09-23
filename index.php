<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .c-header {
      display: grid;
      justify-items: center;
      align-content: center;
    }
  </style>
</head>

<body>
  <?php
  $name = "Dark Matter";
  $read = true;
  $message = "No books read";

  if($read) {
    $message = "You have read $name";
  }
  ?>
  
  <h1>
    <?= $message ?>
  </h1>

</body>

</html>