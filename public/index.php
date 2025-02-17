<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../includes/core/Router.php';
require __DIR__ . '/../includes/controllers/ShipController.php';

use Dotenv\Dotenv;
use App\Core\Router;
use App\Controllers\ShipController;
use App\Controllers\PicsumController; 

// Debug mode
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Database check
$dbPath = $_ENV['DB_PATH'] ?? '../database/starships.db';
$absoluteDbPath = realpath(__DIR__ . '/../' . $dbPath) ?: __DIR__ . '/../' . $dbPath;
$dbExists = file_exists($absoluteDbPath);
$hasData = false;

if ($dbExists) {
    try {
        $db = new SQLite3($absoluteDbPath);
        $result = $db->query("SELECT COUNT(*) as count FROM starships");
        if ($result) {
            $row = $result->fetchArray(SQLITE3_ASSOC);
            $hasData = ($row && $row['count'] > 0);
        }
        $db->close();
    } catch (Exception $e) {
        $dbExists = false;
    }
}

// If database ready, setup routes and run app
if ($dbExists && $hasData) {
    Router::get('', [ShipController::class, 'index']);
    Router::get('ships', [ShipController::class, 'index']);
    Router::get('ships/show/{id}', [ShipController::class, 'show']);
    Router::get('ships/edit/{id}', [ShipController::class, 'edit']);
    Router::post('ships/update/{id}', [ShipController::class, 'update']);
    Router::delete('ships/delete/{id}', [ShipController::class, 'delete']);
    Router::get('ships/add', [ShipController::class, 'create']);
    Router::post('ships/add', [ShipController::class, 'store']);
    Router::get('picsum', [PicsumController::class, 'index']);
    Router::post('picsum/download', [PicsumController::class, 'download']);

    
    Router::dispatch();
    exit;
}

// Handle database setup actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'create_db':
            try {
                $output = [];
                $return_var = 0;
                $command = 'php ' . dirname(__DIR__) . '/migrations.php 2>&1';
                exec($command, $output, $return_var);
                
                if ($return_var !== 0) {
                    throw new Exception("Error en migrations.php: " . implode("\n", $output));
                }
                
                // Recheck database state
                $dbExists = file_exists($absoluteDbPath);
                if ($dbExists) {
                    header("Location: index.php");
                    exit;
                }
            } catch (Exception $e) {
                echo "<div class='status warning'>Error: " . $e->getMessage() . "</div>";
            }
            break;
    
        case 'import_data':
            try {
                $command = sprintf('php "%s/../scripts/import_csv.php"', __DIR__);
                exec($command, $output, $return_var);
                
                if ($return_var !== 0) {
                    throw new Exception("Error al importar datos: " . implode("\n", $output));
                }
                
                // Recheck database state
                $db = new SQLite3($absoluteDbPath);
                $result = $db->query("SELECT COUNT(*) as count FROM starships");
                if ($result) {
                    $row = $result->fetchArray(SQLITE3_ASSOC);
                    $hasData = ($row && $row['count'] > 0);
                }
                $db->close();
    
                if ($hasData) {
                    header("Location: /ships");
                    exit;
                }
            } catch (Exception $e) {
                echo "<div class='status warning'>Error: " . $e->getMessage() . "</div>";
            }
            break;
    }
}
// Show setup page if database not ready
include __DIR__ . '/setup.php';