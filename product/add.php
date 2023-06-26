<h2>Nabídnout produkt</h2>
<form class="norm" action="" method="post" enctype="multipart/form-data">
  <div>
    <input type="text" name="name" placeholder="Název produktu">
  </div>
  <div>
    <textarea name="description" placeholder="Popis" maxlength="450"></textarea>
  </div>
  <div>
    <input type="number" name="price" placeholder="Cena">
  </div>
  <div>
    <input type="file" name="image" accept="image/*">
  </div>
  <div>
    <input type="submit" name="submit" value="Přidat produkt">
  </div>
</form>

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

    if (empty($name) || empty($description) || empty($price) || empty($_FILES['image']['tmp_name'])) {
        echo '<p class="description">Všechna pole formuláře musí být vyplněna.</p>';
    } else {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);

        if ($imageData !== false) {
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, id_user) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsi", $name, $description, $price, $imageData, $userId);

            if ($stmt->execute()) {
                echo '<p class="message">Produkt byl úspěšně přidán do nabídky.</p>';
            } else {
                echo '<p class="message">Chyba při přidávání produktu.</p>';
            }

            $stmt->close();
        } else {
            echo '<p class="message">Chyba při načítání obrázku.</p>';
        }
    }
}

$conn->close();

?>