<?php

session_start();

$pageIdx = isset($_GET['sid']) ? $_GET['sid'] : 0;

require('database.php');

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
            <a href="index.php?sid=offers">Nábídka</a>
        <?php
            if ((isset($_SESSION["user_id"]))) {
                echo '<a href="index.php?sid=products">Mé produkty</a>';
            }
        ?>
            <div class="nav-right">
            <?php
                if (isset($_SESSION["user_id"])) {
                    echo '<a href="index.php?sid=logout">Odhlasit</a>';
                    echo '<a href="index.php?sid=cart">Košík - 0</a>';
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