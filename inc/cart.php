<h2>Váš košík</h2>

<?php
require_once("database.php");

$conn = Connection();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?sid=login");
    exit();
}

$userId = $_SESSION['user_id'];

if (isset($_POST['delete']) && $_POST['delete'] === 'Odstranit') {
    $productName = $_POST['product_name'];

    $deleteQuery = "DELETE FROM cart
                    WHERE id_user = ? AND id_product IN (
                      SELECT id_product FROM products WHERE name = ?
                    )";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("is", $userId, $productName);

    if ($deleteStmt->execute()) {
        echo '<p class="message">Produkt byl úspěšně odstraněn z košíku.</p>';
    } else {
        echo '<p class="message">Nastala chyba při odstraňování produktu z košíku.</p>';
    }

    $deleteStmt->close();
}

if (isset($_POST['order']) && $_POST['order'] === 'Objednat') {
    $deleteAllQuery = "DELETE c, p
                       FROM cart c
                       INNER JOIN products p ON c.id_product = p.id_product
                       WHERE c.id_user = ?";
    $deleteAllStmt = $conn->prepare($deleteAllQuery);
    $deleteAllStmt->bind_param("i", $userId);

    if ($deleteAllStmt->execute()) {
        echo '<p class="message">Objednávka byla úspěšně odeslána.</p>';
    } else {
        echo '<p class="message">Nastala chyba při odesílání objednávky.</p>';
    }

    $deleteAllStmt->close();
}

$selectQuery = "SELECT p.name, p.price
                FROM products p
                INNER JOIN cart c ON p.id_product = c.id_product
                WHERE c.id_user = ?";
$selectStmt = $conn->prepare($selectQuery);
$selectStmt->bind_param("i", $userId);
$selectStmt->execute();
$result = $selectStmt->get_result();

if ($result->num_rows > 0) {
    $totalPrice = 0;

    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $price = $row['price'];

        $totalPrice += $price;

        echo '<div class="container-cart">';
        echo '<p>' . $name . '</p>';
        echo '<p>Cena: ' . $price . ' Kč</p>';
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="product_name" value="' . $name . '">';
        echo '<input type="submit" name="delete" value="Odstranit">';
        echo '</form>';
        echo '</div>';
    }

    echo '<div class="container-total">';
    echo '<p>Celková cena: ' . $totalPrice . ' Kč</p>';
    echo '<form action="" method="post">';
    echo '<input type="submit" name="order" value="Objednat">';
    echo '</form>';
    echo '</div>';
} else {
    echo '<p class="message">Váš košík je prázdný.</p>';
}

$selectStmt->close();
$conn->close();
?>
