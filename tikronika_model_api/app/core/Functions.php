<?php

function esc($str)
{
    return htmlspecialchars($str);
}

function redirect($path)
{
    $path = ltrim($path, '/');
    header('location: ' . ROOT . $path);
}