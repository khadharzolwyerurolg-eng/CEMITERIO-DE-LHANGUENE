<?php
function esc($str)
{
    return htmlspecialchars($str);
}


//Validate email address:::
function validate_form($data)
{
    var_dump($_POST);
}


       /* $errors = [];  // was: $this->$errors (extra $ sign)

        */

function redirect($path)
{
    $path = ltrim($path, '/');
    header('location: ' . ROOT . $path);
}

//Validate::


