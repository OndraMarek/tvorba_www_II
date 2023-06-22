<?php

session_start();

$pageIdx = isset($_GET['sid']) ? $_GET['sid'] : 0;

?>

<!doctype html>
<html lang="cs">

<head>
    <title>Lego Marketplace</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style/style.css">

</head>

<body>
    <header>
        <nav>
            <a href="index.php?sid=home">Hlavní stránka</a>
            <a href="index.php?sid=offers">Nábídka</a>
            <a href="index.php?sid=products">Mé produkty</a>
            <div class="nav-right">
                <a href="index.php?sid=login">Přihlášení</a>
                <a href="index.php?sid=signup">Registrace</a>
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
        case "login":
            include("usr/login.php");
            break;
        case "signup":
            include("usr/signup.php");
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