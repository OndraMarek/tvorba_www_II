<h2>Mé produkty</h2>

<?php

require_once("database.php");

$conn = Connection();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?sid=login");
    exit();
}

if (isset($_POST['delete'])) {
    $productId = $_POST['product_id'];

    $query = "DELETE FROM products WHERE id_product = ? AND id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $productId, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

$query = "SELECT p.*, u.username FROM products p JOIN users u ON p.id_user = u.id WHERE u.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
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
        ?>

        <div class="container">
            <div>
                <img src="data:image/jpeg;base64,<?= base64_encode($imageData) ?>" alt="Obrazek produktu">
            </div>
            <div>
                <h3><?= $name ?></h3>
                <p><?= $description ?></p>
                <h4>Cena: <?= $price ?></h4>
                <p>Prodejce: <?= $username ?></p>
                <form class="norm align" action="" method="post">
                    <input type="hidden" name="product_id" value="<?= $productId ?>">
                    <input type="submit" name="delete" value="Smazat">
                </form>
            </div>
        </div>
        
        <?php
    }
} else {
    echo '<p class="message">Nemáte žádné nabízené produkty.</p>';
}

$stmt->close();
$conn->close();
?>