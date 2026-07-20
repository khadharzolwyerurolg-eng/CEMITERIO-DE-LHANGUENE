<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
    spl_autoload_register(function ($classname)
    {
        if(file_exists(__DIR__ . '/../controllers/' . ucfirst($classname) . '.php'))
        {
            require_once __DIR__ . '/../controllers/' . ucfirst($classname);
        }
        if(file_exists(__DIR__ . '/../models/' . ucfirst($classname) . '.php'))
        {
            require_once __DIR__ . '/../models/' . ucfirst($classname);
        }
    });
    try {
        require_once 'Functions.php';
        require_once 'Controller.php';
        require_once 'App.php';
    } catch (Exception $e) {
        throw new Exception("Erro ao configurar ficheiro INIT: " . $e->getMessage());
    }
} catch (Exception $e) {
    throw new Exception("Erro ao configurar ficheiro INIT: " . $e->getMessage());
}