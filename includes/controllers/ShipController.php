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
        require __DIR__ . '/../views/ships/index.php';  // Updated path
    }

    public function show($id) {
        $ship = $this->repository->getShipById((int)$id);
        if (!$ship) {
            http_response_code(404);
            die("<h3>Nave no encontrada</h3>");
        }
        require __DIR__ . '/../views/ships/show.php';  // Updated path
    }

    public function edit($id) {
        $ship = $this->repository->getShipById((int)$id);
        if (!$ship) {
            http_response_code(404);
            die("<h3>Nave no encontrada</h3>");
        }
         require __DIR__ . '/../views/ships/edit.php';
    }

    // Guardar cambios en una nave
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars(strip_tags($_POST['name']));
            $model = htmlspecialchars(strip_tags($_POST['model']));
            $manufacturer = (int) $_POST['manufacturer_id'];
            $starship_class = (int) $_POST['starship_class_id'];

            $ship = new Ship(
                (int)$id, $name, $model, $manufacturer, $starship_class, 
                null, null, null, null, null, null, null, null, null, null, null, null
            );
            
            $this->repository->updateShip($ship);
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
