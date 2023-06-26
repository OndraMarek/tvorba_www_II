<h2>Registrace</h2>
<form class="norm" action="" method="post">
    <div>
        <input type="text" name="username" placeholder="Uživatelské jméno">
    </div>
    <div>
        <input type="text" name="email" placeholder="Email">
    </div>
    <div>
        <input type="password" name="password" placeholder="Heslo">
    </div>
    <div>
        <input type="password" name="repeat_password" placeholder="Opakujte heslo">
    </div>
    <div>
        <input type="submit" name="submit" value="Registrovat">
    </div>
</form>

<?php
require_once("database.php");

$conn = Connection();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php?sid=home");
    exit();
}

if (isset($_POST['submit'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeat_password'];

    if (!$email) {
      echo '<p class="message">Neplatný formát e-mailu</p>';
      exit();
  }

    if (empty($username) || empty($email) || empty($password) || empty($repeatPassword)) {
        echo '<p class="message">Všechna pole musí být vyplněna</p>';
        exit();
    }

    if ($password !== $repeatPassword) {
        echo '<p class="message">Hesla se neshodují</p>';
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: index.php?sid=login");
        exit();
    } else {
        echo '<p class="message">Chyba při registraci</p>';
    }

    $stmt->close();
}

?>