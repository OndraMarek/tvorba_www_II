<h2>Nabídnout produkt</h2>

<?php

require_once("database.php");

$conn = Connection();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?sid=login");
    exit();
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $userId = $_SESSION['user_id'];

    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $imageData = mysqli_real_escape_string($conn, $imageData);

    if (empty($name) || empty($description) || empty($price) || empty($imageData)) {
        echo '<p class="description">Všechna pole formuláře musí být vyplněna.</p>';
    } else {
        $query = "INSERT INTO products (name, description, price, image, id_user) VALUES ('$name', '$description', '$price', '$imageData', '$userId')";
        $result = $conn->query($query);

        if ($result) {
            echo '<p class="description">Produkt byl úspěšně přidán do nabídky.</p>';
        } else {
            echo '<p class="description">Chyba při přidávání produktu.</p>';
        }
    }
}

$conn->close();

?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="">
    <input type="text" name="name" placeholder="Název produktu">
  </div>
  <div class="">
  <textarea name="description" placeholder="Popis"></textarea>
  </div>
  <div class="">
    <input type="number" name="price" placeholder="Cena">
  </div>
  <div class="">
    <input type="file" name="image" accept="image/*">
  </div>
  <div class="">
    <input type="submit" name="submit" value="Přidat produkt">
  </div>
</form>