<?php

trait Controller
{
    public function view($name, $data = [])
    {
        $filename = 'app/views/' . $name . '.view.php';
        if(file_exists($filename))
        {
            if (is_array($data)) {
                extract($data);
            }
            require_once $filename;
        }else{
            $filename = 'app/views/404.view.php';
            require_once $filename;
        }
    }
}