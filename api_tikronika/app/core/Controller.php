<?php

trait Controller
{
    public function view($name, $data = [])
    {
        $filename = __DIR__ . '/../views/' . $name . '.view.php';
        if (file_exists($filename)) {
            if (is_array($data)) {
                extract($data);
            }
            require_once $filename;
        } else {
            $fallback = __DIR__ . '/../views/404.view.php';
            require_once $fallback;
        }
    }
}