<?php
namespace App\Controllers;

class ShipController {
    
    public static function index() {
        require '../includes/views/ships/index.php';
    }

    public static function create() {
        require '../includes/views/ships/add.php';
    }

    public static function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? 'Desconocida';
            echo "Guardando nave: $name";
        } else {
            echo "Método no permitido";
        }
    }
}
