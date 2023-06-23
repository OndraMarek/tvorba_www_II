<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?sid=login");
    exit();
}


$_SESSION = array();

session_destroy();

header("Location: index.php?sid=login");
exit();
?>