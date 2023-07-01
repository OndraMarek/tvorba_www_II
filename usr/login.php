<h2>Přihlášení</h2>
<form class="norm" action="" method="post">
  <div>
    <input type="text" name="username" placeholder="Uživatelské jméno">
  </div>
  <div>
    <input type="password" name="password" placeholder="Heslo">
  </div>
  <div>
    <input type="submit" name="login" value="Přihlásit">
  </div>
</form>

<?php
require_once("database.php");

$conn = Connection();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php?sid=offers");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        header("Location: index.php?sid=offers");
        exit();
    } else {
        echo '<p class="message">Neplatné přihlašovací údaje</p>';
    }

    $stmt->close();
}
?>