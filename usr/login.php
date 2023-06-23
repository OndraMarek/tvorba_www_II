<?php

require_once("database.php");

if (isset($_SESSION['user_id'])) {
    header("Location: index.php?sid=home");
    exit();
}

$conn = Connection();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT id FROM users WHERE username = ? AND password = SHA1(?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();

    if ($user_id) {
        $_SESSION['user_id'] = $user_id;
        header("Location: index.php?sid=home");
        exit();
    } else {
        echo "Neplatné přihlašovací údaje";
    }
}


?>

<h2>Přihlášení</h2>

<form action="" method="post">
  <div class="">
    <input type="text" name="username" placeholder="Uživatelské jméno">
  </div>
  <div class="">
    <input type="password" name="password" placeholder="Heslo">
  </div>
  <div class="">
    <input type="submit"  name="login" value="Přihlásit">
  </div>
</form>