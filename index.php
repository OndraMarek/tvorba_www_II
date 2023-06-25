<?php

session_start();

$pageIdx = isset($_GET['sid']) ? $_GET['sid'] : 0;

require('database.php');

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
            <a href="index.php?sid=home">Hlavní stránka</a>
            <a href="index.php?sid=offers">Nabídka</a>
        <?php
            if ((isset($_SESSION["user_id"]))) {
                echo '<a href="index.php?sid=products">Mé produkty</a>';
                echo '<a href="index.php?sid=add">Prodat</a>';
            }
        ?>
            <div class="nav-right">
            <?php
                if (isset($_SESSION["user_id"])) {
                    echo '<span class="username">Uživatel: ' . $username . '</span>';
                    echo '<a href="index.php?sid=logout">Odhlasit</a>';
                    echo '<a href="index.php?sid=cart">Košík</a>';
                } else {
                    echo '<a href="index.php?sid=login">Přihlášení</a>';
                    echo '<a href="index.php?sid=signup">Registrace</a>';
                }
            ?>
            </div>
        </nav>
        
        <div>
            <h1>Lego Marketplace</h1>
        </div>
        
    </header>
    <main>
    <?php
    renderDifferentPage($pageIdx);

    function renderDifferentPage($id)
    {
      switch ($id) {
        case "home":
            include("inc/home.php");
            break;
        case "offers":
            include("inc/offers.php");
            break;
        case "products":
            include("inc/products.php");
            break;
        case "add":
            include("product/add.php");
            break;
        case "cart":
            include("inc/cart.php");
            break;
        case "login":
            include("usr/login.php");
            break;
        case "signup":
            include("usr/signup.php");
            break;    
        case "logout":
            include("usr/logout.php");
            break;  
        default:
          include("inc/home.php");
      }
    }
    ?>
    </main>
    <footer>
        <p> Školní projekt v rámci předmětu Tvorba www stránek II | © Ondřej Marek</p>
    </footer>

</body>

</html>