<h2>Nabízené produkty</h2>

<?php
require_once("database.php");

$conn = Connection();

if (isset($_SESSION['user_id'])) {
    $loggedInUserId = $_SESSION['user_id'];
}

if (isset($_POST['submit']) && $_POST['submit'] === 'Zakoupit') {
    $productId = $_POST['product_id'];

    $query = "SELECT id_cart FROM cart WHERE id_user = ? AND id_product = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $loggedInUserId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<p class="message">Produkt již je ve vašem košíku.</p>';
    } else {
        $query = "INSERT INTO cart (id_user, id_product) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $loggedInUserId, $productId);
        if ($stmt->execute()) {
            echo '<p class="message">Produkt byl úspěšně přidán do košíku.</p>';
        } else {
            echo '<p class="message">Nastala chyba při přidávání produktu do košíku.</p>';
        }
    }

    $stmt->close();
}

$query = "SELECT p.*, u.username
          FROM products p
          JOIN users u ON p.id_user = u.id
          LEFT JOIN cart c ON p.id_product = c.id_product AND c.id_user = ?
          WHERE (p.id_user <> ? AND c.id_cart IS NULL) OR (c.id_user IS NULL)
          ORDER BY p.id_product";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $loggedInUserId, $loggedInUserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productId = $row['id_product'];
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $imageData = $row['image'];
        $username = $row['username'];

        echo '<div class="container">';
        echo '<div>';
        echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" alt="Obrazek produktu">';
        echo '</div>';
        echo '<div>';
        echo '<h3>' . $name . '</h3>';
        echo '<p>' . $description . '</p>';
        echo '<h4>Cena:' . $price . '</h4>';
        echo '<p>Prodejce: ' . $username . '</p>';

        if (isset($_SESSION['user_id'])) {
            echo '<form class="aaa" action="" method="post">';
            echo '<input type="hidden" name="product_id" value="' . $productId . '">';
            echo '<input type="submit" name="submit" value="Zakoupit">';
            echo '</form>';
        }
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p class="message">Nebyly nalezeny žádné nabízené produkty.</p>';
}

$stmt->close();
$conn->close();
?>