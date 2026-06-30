<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require "mail.php";

$error = array();
    if(!$con = mysqli_connect("localhost", "terdeu", "54e7OtJM", "forgot_db"))
    {
        die("could not connect");
    }


    $mode = "enter_email";

    if(isset($_GET['mode']))
    {
        $mode = $_GET['mode'];

        //Something is posted::
        if(count($_POST) > 0){
            switch ($mode) {
                case 'enter_email':
                    # code...
                    $email = $_POST["email"]; 
                    //Validade email::
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $error[] = "Please enter a valid email";
                    }elseif(!valid_email($email)){
                        $error[] = "That email was not found!";
                    }else{
                        $_SESSION['forgot']['email'] = $email;
                        send_email($email);
                        header("Location: forgot.php?mode=enter_code");
                        die;
                    }    
                    break;
                case 'enter_code':
                    # code...
                    $code = $_POST["code"];
                    $result = is_code_correct($code);
                    if($result == "The code is correct"){
                        $_SESSION['forgot']['code'] = $code;
                        header("Location: forgot.php?mode=enter_password");
                        die;
                    }else{
                        $error[] = $result;
                    }
                    
                    break;
                case 'enter_password':
                    # code...
                    $password = $_POST['password'];
                    $password2 = $_POST['password2'];

                    if($password !== $password2){
                        $error[] = "Password doesn't match";
                    }elseif(!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])){
                        header("Location: forgot.php");
                        die;
                    }else{
                        save_password($password);
                        if(isset($_SESSION['forgot'])){
                            unset($_SESSION['forgot']);
                        }
                        header("Location: login.php");
                        die;
                    }
                    break;
                
                default:
                    # code...
                    break;
            }

        }
    }

    function send_email($email){
        global $con;

        $expire = time() + (60 * 1);
        $code = random_int(10000, 99999);
        $email = $email;

        $query = "insert into verification_code (email, code, expire) value('$email', '$code', '$expire')";
        

        mysqli_query($con, $query);

        $message = "Your code is ". $code;
        $subject = "Email verification";
        send_mail($email,$subject,$message);
        
    }

    function save_password($password){
        global $con;

        $password = password_hash($password, PASSWORD_DEFAULT);
        $email = $_SESSION['forgot']['email'];
        

        $query = "update users set password = '$password' where email = '$email' limit 1";

        mysqli_query($con, $query);

    }

    function valid_email($email){
        global $con;
        $email = $email;

        
        $query = "select * from users where email = '$email' limit 1";

        $result = mysqli_query($con, $query);
        if($result){
            if(mysqli_num_rows($result) > 0){
                return true;
            }
        }

        return false;
    }

    function is_code_correct($code){
        global $con;

        $code = $code;
        $expire = time();
        $email = $_SESSION['forgot']['email'];

        $query = "select * from verification_code where code = '$code' && email = '$email'";

        $result = mysqli_query($con, $query);
        if($result){
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                if($row['expire'] > $expire){
                    return "The code is correct";
                }else{
                    return "The code is expired";
                }
            }else{
                return "The code is incorrect";
            }
        }

        return false;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot</title>
</head>
<body>
    <style type="text/css">
        *{
            font-family: tahoma;
            font-size: 13px;
        }

        form{
            width: 100%;
            max-width: 200px;
            margin: auto;
            border: solid thin #ccc;
            padding: 10px;
        }
        .textbox{
            paddin: 5px;
            width: 180px;
        }
    </style>

            <?php
        
                switch ($mode) {
                    case 'enter_email':
                        # code...
                        ?>
                            <form method="post" action="forgot.php?mode=enter_email">
                            <h2>Forgot Password</h2>
                            <h3>Emter your email below</h3>
                                <span style="font-size: 12px; color:red;">
                                    <?php
                                        foreach($error as $err){
                                            echo $err . "<br>";
                                        }
                                    ?>
                                </span>
                                <input type="email" class="textbox" name="email" placeholder="Email"><br>
                                <br style="clear: both;">
                                <input type="submit" value="Next">
                                <br><br>
                                <div><a href="login.php">Login</a></div>
                            </form>
                        <?php
                        break;
                    case 'enter_code':
                        # code...
                        ?>
                            <form method="post" action="forgot.php?mode=enter_code">
                            <h2>Forgot Password</h2>
                            <h3>Emter your the code sent to your email</h3>
                                <span style="font-size: 12px; color:red;">
                                    <?php
                                        foreach($error as $err){
                                            echo $err . "<br>";
                                        }
                                    ?>
                                </span>
                                <input type="text" class="textbox" name="code" placeholder="12345"><br>
                                <br style="clear: both;">
                                <input type="submit" value="Next" style="float: right;">
                                <a href="forgot.php">
                                    <input type="button" value="Start Over">
                                </a>
                                <br><br>
                                <div><a href="login.php">Login</a></div>
                            </form>
                        <?php
                        break;
                    case 'enter_password':
                        # code...
                        ?>
                            <form method="post" action="forgot.php?mode=enter_password">
                            <h2>Forgot Password</h2>
                            <h3>Emter your new password</h3>
                                <span style="font-size: 12px; color:red;">
                                    <?php
                                        foreach($error as $err){
                                            echo $err . "<br>";
                                        }
                                    ?>
                                </span>
                                <input type="password" class="textbox" name="password" placeholder="Password"><br>
                                <input type="password" class="textbox" name="password2" placeholder="Retype password"><br>
                                <br style="clear: both;">
                                <input type="submit" value="Next" style="float: right;">
                                <a href="forgot.php">
                                    <input type="button" value="Start Over">
                                </a>
                                <br><br>
                                <div><a href="login.php">Login</a></div>
                            </form>
                        <?php
                        break;
                    
                    default:
                        # code...
                        break;
                }
            ?>

</body>
</html>