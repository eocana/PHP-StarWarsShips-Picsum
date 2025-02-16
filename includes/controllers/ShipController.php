<?php
namespace App\Controllers;

use App\Models\ShipRepository;
use App\Models\Ship;

/**
 * Controlador ShipController
 * Maneja las solicitudes relacionadas con las naves espaciales, como listar, mostrar, crear, actualizar y eliminar naves.
 */
class ShipController {
    private ShipRepository $repository;

    /**
     * Constructor: Inicializa el repositorio de naves.
     */
    public function __construct() {
        $this->repository = new ShipRepository();
    }

    /**
     * Método index: Lista todas las naves y carga la vista correspondiente.
     */
    public function index() {
        $ships = $this->repository->getAllShips();
        require __DIR__ . '/../views/ships/index.php';  
    }

    /**
     * Método show: Muestra una nave específica según su ID.
     *
     * @param int $id ID de la nave.
     */
    public function show($id) {
        $ship = $this->repository->getShipById((int)$id);
        if (!$ship) {
            http_response_code(404);
            die("<h3>Nave no encontrada</h3>");
        }
        require __DIR__ . '/../views/ships/show.php';  
    }

    /**
     * Método edit: Carga el formulario de edición de una nave.
     *
     * @param int $id ID de la nave a editar.
     */
    public function edit($id) {
        $ship = $this->repository->getShipById((int)$id);
        $manufacturers = $this->repository->getAllManufacturers();
        $starship_classes = $this->repository->getAllStarshipClasses();
        
        if (!$ship) {
            http_response_code(404);
            die("<h3>Nave no encontrada</h3>");
        }

        require __DIR__ . '/../views/ships/edit.php';
    }

    /**
     * Método create: Carga el formulario para agregar una nueva nave.
     */
    public function create() {
        $manufacturers = $this->repository->getAllManufacturers();
        $starship_classes = $this->repository->getAllStarshipClasses();
        require __DIR__ . '/../views/ships/add.php';
    }

    /**
     * Convierte valores numéricos opcionales en enteros o null.
     *
     * @param mixed $value Valor a convertir.
     * @return int|null Retorna el valor convertido o null si no es válido.
     */
    private function parseNullableInt($value) {
        if (empty($value) || $value === 'unknown' || $value === 'n/a' || $value === '0') {
            return null;
        }
        return (int)$value;
    }
    
    /**
     * Método store: Guarda una nueva nave en la base de datos.
     */
    public function store() {
        try {
            $ship = new Ship(
                null, // ID nulo para nuevas naves
                $_POST['name'],
                $_POST['model'],
                $this->getManufacturerId($_POST),
                $this->getStarshipClassId($_POST),
                $this->parseNullableInt($_POST['cost_in_credits']),
                (float)($_POST['length'] ?? 0),
                $this->parseNullableInt($_POST['max_speed']),
                $_POST['crew'] ?? '',
                $this->parseNullableInt($_POST['passengers']),
                $_POST['cargo_capacity'] ?? 0,
                $_POST['consumables'] ?? '',
                (float)($_POST['hyperdrive_rating'] ?? 0),
                $_POST['mglt'] ?? 0,
                date('Y-m-d H:i:s'), // Fecha de creación
                date('Y-m-d H:i:s'), // Fecha de edición
                $_POST['api_url'] ?? ''
            );
    
            if ($this->repository->addShip($ship)) {
                header('Location: /ships');
                exit;
            }
        } catch (\Exception $e) {
            // En caso de error, redirigir con un mensaje de error
            header('Location: /ships/add?error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    /**
     * Obtiene el ID del fabricante, creando uno nuevo si es necesario.
     *
     * @param array $data Datos del formulario.
     * @return int|null ID del fabricante.
     */
    private function getManufacturerId($data) {
        if (isset($data['manufacturer_id']) && $data['manufacturer_id'] === 'new' && !empty($data['new_manufacturer'])) {
            return $this->repository->addManufacturer($data['new_manufacturer']);
        }
        return $data['manufacturer_id'] ?? null;
    }
    
    /**
     * Obtiene el ID de la clase de nave, creando una nueva si es necesario.
     *
     * @param array $data Datos del formulario.
     * @return int|null ID de la clase de nave.
     */
    private function getStarshipClassId($data) {
        if (isset($data['starship_class_id']) && $data['starship_class_id'] === 'new' && !empty($data['new_class'])) {
            return $this->repository->addStarshipClass($data['new_class']);
        }
        return $data['starship_class_id'] ?? null;
    }

    /**
     * Método update: Actualiza los datos de una nave existente.
     *
     * @param int $id ID de la nave a actualizar.
     */
    public function update($id) {
        try {
            $ship = new Ship(
                $id,
                $_POST['name'],
                $_POST['model'],
                $this->getManufacturerId($_POST),
                $this->getStarshipClassId($_POST),
                $_POST['cost_in_credits'] ?? 0,
                (float)($_POST['length'] ?? 0),
                $_POST['max_speed'] ?? 0,
                $_POST['crew'] ?? '',
                $_POST['passengers'] ?? 0,
                $_POST['cargo_capacity'] ?? 0,
                $_POST['consumables'] ?? '',
                (float)($_POST['hyperdrive_rating'] ?? 0),
                $_POST['mglt'] ?? 0,
                null, // La fecha de creación se mantiene
                date('Y-m-d H:i:s'), // Fecha de edición actualizada
                $_POST['api_url'] ?? ''
            );
    
            if ($this->repository->updateShip($ship)) {
                header('Location: /ships');
                exit;
            }
        } catch (\Exception $e) {
            header('Location: /ships/edit/' . $id . '?error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    /**
     * Método delete: Elimina una nave de la base de datos.
     *
     * @param int $id ID de la nave a eliminar.
     */
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->repository->deleteShip((int)$id);
        }
        header("Location: /ships");
        exit;
    }
}
