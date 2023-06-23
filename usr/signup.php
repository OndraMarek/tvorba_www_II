<?php

if (isset($_SESSION['user_id'])) {
    header("Location: index.php?sid=home");
    exit();
}

?>

<h2>Registrace</h2>

<form action="" method="post">
  <div class="">
    <input type="text" name="username" placeholder="Uživatelské jméno">
  </div>
  <div class="">
    <input type="text" name="fullname" placeholder="Email">
  </div>
  <div class="">
    <input type="password" name="password" placeholder="Heslo">
  </div>
  <div class="">
    <input type="password" name="repeat_password" placeholder="Opakujte heslo">
  </div>
  <div class="">
    <input type="submit" name="submit" value="Registrovat">
  </div>
</form>