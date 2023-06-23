<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<h2>Váš košík</h2>

<div class="container cart">
        <h3>8988 Lego City</h3>
        <h4>500 Kč</h4>
        <input type="submit" name="submit" value="Odstranit">
    </div>
</div>

<div class="container cart">
        <h3>8988 Lego City</h3>   
        <h4>500 Kč</h4>
        <input type="submit" name="submit" value="Odstranit">
    </div>
</div>