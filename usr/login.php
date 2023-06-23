<?php

require_once("database.php");

$conn = Connection();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php?sid=home");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Získání uloženého hesla z databáze pro zadaného uživatele
    $query = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if ($hashed_password && password_verify($password, $hashed_password)) {
        // Přihlášení úspěšné
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