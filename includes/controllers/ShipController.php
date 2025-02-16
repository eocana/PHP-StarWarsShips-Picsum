<?php
namespace App\Controllers;

use App\Models\ShipRepository;
use App\Models\Ship;

class ShipController {
    private ShipRepository $repository;

    public function __construct() {
        $this->repository = new ShipRepository();
    }

    public function index() {
        $ships = $this->repository->getAllShips();
        require __DIR__ . '/../views/ships/index.php';  
    }

    public function show($id) {
        $ship = $this->repository->getShipById((int)$id);
        if (!$ship) {
            http_response_code(404);
            die("<h3>Nave no encontrada</h3>");
        }
        require __DIR__ . '/../views/ships/show.php';  
    }

    public function edit($id) {
        $ship = $this->repository->getShipById((int)$id);
        if (!$ship) {
            http_response_code(404);
            die("<h3>Nave no encontrada</h3>");
        }
         require __DIR__ . '/../views/ships/edit.php';
    }

    public function create() {
        $manufacturers = $this->repository->getAllManufacturers();
        $starship_classes = $this->repository->getAllStarshipClasses();
        require __DIR__ . '/../views/ships/add.php';
    }

    public function store() {
        try {
            $ship = new Ship(
                null, // id is null for new ships
                htmlspecialchars(strip_tags($_POST['name'])),
                htmlspecialchars(strip_tags($_POST['model'])),
                $_POST['manufacturer_id'] === 'new' 
                    ? $this->repository->addManufacturer($_POST['new_manufacturer'])
                    : (int)$_POST['manufacturer_id'],
                $_POST['starship_class_id'] === 'new'
                    ? $this->repository->addStarshipClass($_POST['new_class'])
                    : (int)$_POST['starship_class_id'],
                (int)$_POST['cost_in_credits'],
                (float)$_POST['length'],
                (int)$_POST['max_speed'],
                htmlspecialchars(strip_tags($_POST['crew'])),
                (int)$_POST['passengers'],
                (int)$_POST['cargo_capacity'],
                htmlspecialchars(strip_tags($_POST['consumables'])),
                (float)$_POST['hyperdrive_rating'],
                (int)$_POST['mglt'],
                date('Y-m-d H:i:s'), // created_at
                date('Y-m-d H:i:s'), // edited_at
                htmlspecialchars(strip_tags($_POST['api_url'] ?? ''))
            );
    
            if ($this->repository->addShip($ship)) {
                header('Location: /ships');
                exit;
            }
        } catch (\Exception $e) {
            // Log error and redirect with error message
        }
        
        header('Location: /ships');
    }

    // Guardar cambios en una nave
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ship = new Ship(
                (int)$id,
                htmlspecialchars(strip_tags($_POST['name'])),
                htmlspecialchars(strip_tags($_POST['model'])),
                (int)$_POST['manufacturer_id'],
                (int)$_POST['starship_class_id'],
                (int)$_POST['cost_in_credits'],
                (float)$_POST['length'],
                (int)$_POST['max_speed'],
                htmlspecialchars(strip_tags($_POST['crew'])),
                (int)$_POST['passengers'],
                (int)$_POST['cargo_capacity'],
                htmlspecialchars(strip_tags($_POST['consumables'])),
                (float)$_POST['hyperdrive_rating'],
                (int)$_POST['mglt'],
                $_POST['created_at'],
                date('Y-m-d H:i:s'), // updated now
                htmlspecialchars(strip_tags($_POST['api_url']))
            );
            
            if ($this->repository->updateShip($ship)) {
                header('Location: /ships');
                exit;
            }
        }
        header("Location: /ships");
        exit;
    }

    // Eliminar una nave
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->repository->deleteShip((int)$id);
        }
        header("Location: /ships");
        exit;
    }
}
