<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<h2>Mé produkty</h2>

<div class="container">
    <div>
        <img src="testimg.jpg" alt="Obrazek produktu">
    </div>
    <div>
        <h3>8988 Lego City</h3>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptate quibusdam velit soluta mollitia, 
            similique laudantium ab quia, eum expedita minus, suscipit eligendi? Nulla enim maiores laudantium, 
            necessitatibus ducimus totam deserunt.</p>
        <h4>500 Kč</h4>
        <p>Prodejce: JanNovak</p>
        <input type="submit" name="submit" value="Upravit">
        <input type="submit" name="submit" value="Smazat">
    </div>
</div>

<div class="container">
    <div>
        <img src="testimg.jpg" alt="Obrazek produktu">
    </div>
    <div>
        <h3>8988 Lego City</h3>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptate quibusdam velit soluta mollitia, 
            similique laudantium ab quia, eum expedita minus, suscipit eligendi? Nulla enim maiores laudantium, 
            necessitatibus ducimus totam deserunt.</p>
        <h4>500 Kč</h4>
        <p>Prodejce: JanNovak</p>
        <input type="submit" name="submit" value="Upravit">
        <input type="submit" name="submit" value="Smazat">
    </div>
</div>
<input type="submit" name="submit" value="Prodat">


