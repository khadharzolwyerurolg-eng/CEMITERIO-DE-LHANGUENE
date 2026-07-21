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

    private function loadErrorPage($statusCode, $controllerName)
    {
        http_response_code($statusCode);
        require_once 'app/controllers/' . $controllerName . '.php';
        $this->controller = $controllerName;
        $this->controller = new $this->controller;
        $this->method = 'index';
        call_user_func_array([$this->controller, $this->method], []);
    }

    private function loadForbiddenPage()
    {
        $this->loadErrorPage(403, '_403');
    }

    private function loadNotFoundPage()
    {
        $this->loadErrorPage(404, '_404');
    }

    public function loadController()
    {
        $URL = $this->slitURL();
        $controllerName = $URL[0] ?? 'home';

        if ($controllerName === '403' || $controllerName === 'forbidden') {
            $this->loadForbiddenPage();
            return;
        }

        $filename = 'app/controllers/' . ucfirst($controllerName) . '.php';
        if (!file_exists($filename)) {
            $this->loadNotFoundPage();
            return;
        }

        require_once $filename;
        $this->controller = ucfirst($controllerName);
        unset($URL[0]);

        $this->controller = new $this->controller;
        if (!empty($URL[1])) {
            if (method_exists($this->controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            } else {
                $this->loadNotFoundPage();
                return;
            }
        }

        call_user_func_array([$this->controller, $this->method], $URL);
    }
}

