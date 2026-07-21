<?php
class Usuarios
{
    use Controller;

    public function index()
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => [
                ['id' => 1, 'nome' => 'Ana'],
                ['id' => 2, 'nome' => 'Bruno']
            ]
        ]);
    }
}
