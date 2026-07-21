<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    spl_autoload_register(function ($classname) {
        $controllerFile = __DIR__ . '/../controllers/' . ucfirst($classname) . 'Controller.php';
        $controllerFallback = __DIR__ . '/../controllers/' . ucfirst($classname) . '.php';
        $modelFile = __DIR__ . '/../models/' . ucfirst($classname) . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            return;
        }

        if (file_exists($controllerFallback)) {
            require_once $controllerFallback;
            return;
        }

        if (file_exists($modelFile)) {
            require_once $modelFile;
        }
    });

    try {
        require_once 'Functions.php';
        require_once 'Controller.php';
        require_once 'App.php';
    } catch (Exception $e) {
        throw new Exception('Erro ao configurar ficheiro INIT: ' . $e->getMessage());
    }
} catch (Exception $e) {
    throw new Exception('Erro ao configurar ficheiro INIT: ' . $e->getMessage());
}