<?php
// Om det finns en get request som händer i sidan..
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  // Jag gör två arrays, en som sparar problemmedelande till namn, epost och lösenord, så att det blir mycket smedigare att hantera felmedelanden sen de finns i samma ställe.
  $err = array("name" => "", "email" => "", "pass" => "");
  $state = array("name" => "", "email" => "", "pass" => "");

  // Jag gör samma här, jag sparar alla regex i en array, eftersom om jag ska utveckla eller ändra på mina regex då updateras det för alla inputfält,
  $reg = array(
    // Namnet ska innehålla endast bokstäver från a till z och det ska gälla för hela meningen (^) och ett nytt rätt värde kan inte inträffa efter felaktig del ($), och inmatningen ska vara åtminstone en bokstav (+) och bokstäver kan vara små eller stora (\i), "^$+ finns i de andra regex och funkar likadant"
    "name" => "/^[a-z]+$/i",
    // () står för group, första group ska innehålla bokstäver siffror (\d) punkter och bindestreck, @ tecknet, sen samma som första delen men punkter är inte tillåtna, punkt, bokstäner (minst 2, max 8), sen samma del igen men inte obligatorisk (?) (.com eller .co.uk)
    "email" => "/^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/",
    // Siffror och bokstäver (\w) mist 8 max 20 @ tecknet och bindestreck är tillåtna
    "pass" => "/^[\w@-]{8,20}$/i"
  );

  // Om någon av input fält är toma när man skickar GET requestet..
  if (empty($_GET['name'])) {
    // Lägg till felmedellande i err array, value som har 'name' neckel
    $err['name'] = 'A name is required';
  }
  if (empty($_GET['email'])) {
    $err['email'] = 'An email is required';
  }
  if (empty($_GET['pass'])) {
    $err['pass'] = 'A password is required';
  }

  // Om det finns err arrayn är tomt (allså det finns inte felmedellande)...
  if (!$err['name'] && !$err['email'] && !$err['pass']) {
    
    // Spara inmatningar i varsin variabel
    $name = $_GET['name'];
    $email = $_GET['email'];
    $pass = $_GET['pass'];

    // echo "<div style='color: red'> <h4>BEFORE:</h4>";
    // echo $name . "<br>" . $email  . "<br>" . $pass;
    // echo "</div>";

    // Sanera inmatningar och ta bort förata 32 tecknar i ACSII-tabell
    $name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

    // Tar bort alla tecknar föruttom bokstäver, siffror och !#$%&'*+-=?^_`{|}~@.[].
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    // tar bort förata 32 tecknar i ACSII-tabell
    $email = filter_var($email, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW);

    $pass = filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);


    // echo "<div> <h4>BEFORE:</h4>";
    // echo $name . "<br>" . $email  . "<br>" . $pass;
    // echo "</div>";

    // Om inmatningen passar våran regular expression och innehåller ej felaktiga bytar (mb_check_encoding) i UTF-8 encoding
    if(preg_match($reg["name"], $name) && mb_check_encoding($name, 'UTF-8')){
      // Lägg till status till namn i state array
      $state["name"] = "<b>$name</b> is a valid name";
    } else {
      // annars lägg till ett felmedellande på namn i err array
      $err["name"] = "<b>$name</b> is not a valid name";
    }

    // Här gör vi likadant men använder en filter som undersöker om inmatningen är ett riktigt epost
    if(filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match($reg["email"], $email) && mb_check_encoding($email, 'UTF-8')){
      $state["email"] = "<b>$email</b> is a valid email";
    } else {
      $err["email"] = "<b>$email</b> is not a valid email";
    }

    if(preg_match($reg["pass"], $pass) && mb_check_encoding($pass, 'UTF-8')){
      $state["pass"] = "<b>$pass</b> is a valid password";
    } else {
      $err["pass"] = "<b>$pass</b> is not a valid password";
    }
  }

}
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