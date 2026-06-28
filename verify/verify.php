<?php
require "functions.php";
require "mail.php";
check_login();

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "GET" && !check_verified()){

//Send email::
$vars['code'] = random_int(10000, 99999);

//Save to database::
$vars['expires'] = (time() + (60 * 60 * 24));
$vars['email'] = $_SESSION['USER']->email;

//Query::
$query = "insert into verify (code, expires, email) values(:code, :expires, :email)";
database_run($query, $vars);

$message = "Your code is ". $vars['code'];
$subject = "Email verification";
$recipient = $vars['email'];
send_mail($recipient,$subject,$message);
}

//
if($_SERVER['REQUEST_METHOD'] == "POST"){

if(!check_verified()){
    $query = "select * from verify where code = :code && email = :email";
    $vars  = array();
    $vars['email'] = $_SESSION['USER']->email;
    $vars['code'] = $_POST['code'];

    $row = database_run($query, $vars);

    if(is_array($row)){
        $row = $row[0];
        $time = time();

        if($row->expires > $time){
            $id = $_SESSION['USER']->id;
            $query = "update users set email_verified = email where id = '$id'";
            database_run($query);

            header("Location: profile.php");
            die;

        }else{
            echo "Code expired!";
        }
    }else{
        echo "Wrong code!";
    }
}else{
    echo "Youre already verified";
}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify</title>
</head>
<body>
    <h1>Verify page</h1>
    <?php include("header.php")?>
    <br><br>
    <div>
        <br> An email was send to your address. past the from the 
            email here!
        <div>
             <?php if(count($errors) > 0):?>
                <?php foreach ($errors as $error):?>
                    <?= $error?><br>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <form method="POST">
            <input type="text" name="code" placeholder="Enter your code"><br>
            <br>
            <input type="submit" value="Verify">
        </form>
    </div>
</body>
</html>