<?php
session_start();

$pageIdx = isset($_GET['sid']) ? $_GET['sid'] : 'home';

require 'database.php';

$conn = Connection();

$username = "";

if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
    $query = "SELECT username FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row["username"];
    }

    $stmt->close();
}
?>

<!doctype html>
<html lang="cs">

<head>
    <title>Lego Marketplace</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <header>
        <nav>

            <a href="index.php?sid=offers">Nabídka</a>

            <?php if (isset($_SESSION["user_id"])) : ?>
                <a href="index.php?sid=products">Mé produkty</a>
                <a href="index.php?sid=add">Prodat</a>
            <?php endif; ?>

            <div class="nav-right">
                <?php if (isset($_SESSION["user_id"])) : ?>
                    <span class="username">Uživatel: <?php echo $username; ?></span>
                    <a href="index.php?sid=logout">Odhlásit</a>
                    <a href="index.php?sid=cart">Košík</a>
                <?php else : ?>
                    <a href="index.php?sid=login">Přihlášení</a>
                    <a href="index.php?sid=signup">Registrace</a>
                <?php endif; ?>
            </div>
        </nav>
        
        <div>
            <h1>Lego Marketplace</h1>
        </div>
    </header>
    <main>
        <?php renderDifferentPage($pageIdx); ?>

        
    </main>

    <footer>
        <p>Školní projekt v rámci předmětu Tvorba www stránek II | © Ondřej Marek</p>
    </footer>
</body>

</html>

<?php function renderDifferentPage($id)
        {
            $pages = [
                "offers" => "inc/offers.php",
                "products" => "inc/products.php",
                "add" => "product/add.php",
                "cart" => "inc/cart.php",
                "login" => "usr/login.php",
                "signup" => "usr/signup.php",
                "logout" => "usr/logout.php",
            ];

            $page = $pages[$id] ?? "inc/offers.php";
            include $page;
        } ?>