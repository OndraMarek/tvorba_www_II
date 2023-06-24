<h2>Nabízené produkty</h2>

<?php
require_once("database.php");

$conn = Connection();

$query = "SELECT p.*, u.username FROM products p JOIN users u ON p.id_user = u.id ORDER BY p.id_product";
$result = $conn->query($query);

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
        echo '<input type="submit" name="submit" value="Zakoupit">';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p class="message">Nebyli nalezeny žádné nabízené produkty.</p>';
}

$conn->close();
?>