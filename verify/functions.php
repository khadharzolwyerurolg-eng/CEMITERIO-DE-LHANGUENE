<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
//Signup::
function signup($data)
{
    $errors = array();

    //Validate::
    if(!preg_match("/^[a-zA-Z ]+$/", $data['username'])){
        $errors[] = "Please enter a valid username";
    }

    if(!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email";
    }

    if(strlen(trim($data["password"])) < 4){
        $errors[] = "Password must be atlest 4 chars long";
    }

    if($data["password"] != $data["password2"]){
        $errors[] = "Password must match";
    }
    // Check Email::
    $check = database_run("select * from users where email = :email", ['email'=> $data["email"] ]);
    if(is_array($check)){
        $errors[] = "That email already exists";
    }

    //Save::
    if(count($errors) == 0){
        $arr['username'] = $data['username'];
        $arr['email'] = $data['email'];
        $arr['password'] = hash('sha256',$data['password']);
        $arr['date'] = date("Y-m-d H-i-s");

        $query = "insert into users (username, email, password, date) values
        (:username, :email, :password, :date)";

        database_run($query, $arr);
    } 
    return $errors;
}

//Login::

function login($data)
{
    $errors = array();

    //Validate::
    if(!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email";
    }

    if(strlen(trim($data["password"])) < 4){
        $errors[] = "Password must be atlest 4 chars long";
    }

    //Check::
    if(count($errors) == 0){
        $arr['email'] = $data['email'];
        $password = hash('sha256',$data['password']);
        
        $query = "select *  from users where email = :email";

        $row = database_run($query, $arr);

        if(is_array($row)){
            $row = $row[0];
            
            if($password === $row->password){
                $_SESSION['USER'] = $row;
                $_SESSION['LOGGED_IN'] = true;
            }else{
                $errors[] = "Wrong email or password";
            }
        }else{
            $errors[] = "Wrong email or password";
        }
    } 
    return $errors;
}
//
function database_run($query, $vars = array())
{
    $string = "mysql:host=localhost;dbname=verify_db";
    $con = new PDO($string, 'terdeu', '54e7OtJM');

    if(!$con){
        return false;
    }

    $stm = $con->prepare($query);
    $check = $stm->execute($vars);

    if($check){
        $data = $stm->fetchAll(PDO::FETCH_OBJ);
        if(count($data) > 0){
            return $data;
        }
    }

    return false;
}

// Check login::
function check_login($redirect = true){
    if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){
        return true;
    }

    if($redirect){
        header("Location: login.php");
        die;
    }else{
        return false;
    }

}

// Check Verify::
function check_verified($redirect = true){
    if($_SESSION['USER']->email == $_SESSION['USER']->email_verified){
        return true;
    }

    return false;

}