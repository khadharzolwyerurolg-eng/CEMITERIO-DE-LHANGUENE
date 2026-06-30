<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!$con = mysqli_connect("localhost", "terdeu", "54e7OtJM", "forgot_db"))
{
    die("could not connect");
}


/*
$password = password_hash('password', PASSWORD_DEFAULT);
$query = "update users set password = '$password' ";
mysqli_query($con, $query);
*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot-Home</title>
</head>
<body>
    <h2>Home-Page</h2>
</body>
</html>