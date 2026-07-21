<?php

class Home
{

    use Controller;
    public function index()
    {
        $this->view('home');
    }
}
