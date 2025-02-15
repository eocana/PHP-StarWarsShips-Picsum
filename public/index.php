<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';  // Cargar el autoload de Composer

use App\Core\Router;  // Usar el Router
use App\Controllers\ShipController;  // Usar el controlador

// Definir rutas
Router::get('', function() {
    echo "<h1>Página de inicio</h1><a href='/ships'>Ver listado de naves</a>";
});

Router::get('ships', [ShipController::class, 'index']);
Router::get('ship/add', [ShipController::class, 'create']);
Router::post('ship/add', [ShipController::class, 'store']);

// Ejecutar el enrutador
Router::dispatch();