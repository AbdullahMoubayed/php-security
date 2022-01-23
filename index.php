<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>PHP Säkerhet</title>
</head>
<body>
  <section>
  <div class="result">
    <span><?php echo($err['name']); echo($state['name']); ?></span>
    <span><?php echo($err['email']); echo($state['email']); ?></span>
    <span><?php echo($err['pass']); echo($state['pass']); ?></span>
  </div>
  <form method="GET" action="index.php">
    <label for="name">Namn</label>
    <input type="text" id="name" name="name">
    <div class="err" id="name-err">Name must be and contain 5 - 12 characters</div>
  
    <label for="email">E-post</label>
    <input type="text" name="email" id="email">
    <div class="err" id="email-err">Email must be a valid address, e.g. me@mydomain.com</div>
  
    <label for="pass">Lösenord</label>
    <input type="text" name="pass" id="pass">
    <div class="err" id="pass-err">Password must alphanumeric (@, _ and - are also allowed) and be 8 - 20 characters</div>
  
    <input type="submit" value="kom igång">
  
  </form>
</section>

<script src="app.js"></script>
</body>
</html>