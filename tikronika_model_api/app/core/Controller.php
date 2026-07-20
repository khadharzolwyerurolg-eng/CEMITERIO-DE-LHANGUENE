<?php

trait Controlle
{
    public function view($name, $data = [])
    {
        try {
            $filename = 'app/views/' . $name . '.view.php';
            if(file_exists($filename))
            {
                if($name === '403')
                {
                    $filename = 'app/views/403.views.php';
                    require_once $filename;
                }
                if(is_array($data))
                {
                    extract($data);
                }
                require_once $filename;
            }
        } catch (Exception $e) {
            throw new Exception('Ocorreu um erro ao carregar a view: ' . $e->getMessage());
        }
    }
}