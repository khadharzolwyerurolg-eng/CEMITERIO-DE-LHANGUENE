<?php

session_destroy();


if(isset($_SESSION['USER'])){
    unset($_SESSION['USER']);
}

if(isset($_SESSION['LOGGED_IN'])){
    unset($_SESSION['LOGGED_IN']);
}

header("Location: login.php");
die;