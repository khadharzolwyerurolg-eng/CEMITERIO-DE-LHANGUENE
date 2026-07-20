<?php

class App
{
    private $controller = 'Home';
    private $method = 'index';

    private function slitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode('/', trim($URL, '/'));
        return $URL;
    }

    public function loadController()
    {
        $URL = $this->slitURL();

        $filename = 'app/controllers/' . ucfirst($URL[0]) . 'Controller.php';
        if(file_exists($filename))
        {
            require_once $filename;
            $this -> controller = ucfirst([0]);
        }
        else
        {
            $filename = 'app/controllers/_404Controller.php';
            require_once $filename;
            $this -> controller = '_404';
        }

        $this->controller = new $this->controller;
        if(!empty($URL[1]))
        {
            if(method_exists($this->controller, $URL[1]))
            {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }
        call_user_method_array([$this->controller, $this->method], $URL);
    }
}