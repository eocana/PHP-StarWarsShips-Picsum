<?php
namespace App\Models;

use SQLite3;

class ShipRepository {
    private SQLite3 $db;

    public function __construct() {
        $this->db = new SQLite3(__DIR__ . '/../../database/starships.db');
        $this->db->busyTimeout(5000); // Evita bloqueos
    }

    public function getAllShips(): array {
        $stmt = $this->db->prepare(
            "SELECT s.id, s.name, s.model,
                    m.name AS manufacturer_name,
                    c.class_name AS starship_class,
                    sp.cost_in_credits, sp.length, sp.max_speed, sp.crew, sp.passengers,
                    sp.cargo_capacity, sp.consumables, sp.hyperdrive_rating, sp.mglt,
                    sa.created_at, sa.edited_at, sa.api_url
             FROM starships s
             LEFT JOIN manufacturers m ON s.manufacturer_id = m.id
             LEFT JOIN starship_classes c ON s.starship_class_id = c.id
             LEFT JOIN starship_specs sp ON s.id = sp.starship_id
             LEFT JOIN starship_api_metadata sa ON s.id = sa.starship_id"
        );
        
        if (!$stmt) {
            return [];
        }
        
        $result = $stmt->execute();
        $ships = [];
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $ships[] = [
                'id' => $row['id'],
                'name' => htmlspecialchars($row['name'] ?? ''),
                'model' => htmlspecialchars($row['model'] ?? ''),
                'manufacturer_name' => htmlspecialchars($row['manufacturer_name'] ?? ''),
                'starship_class' => htmlspecialchars($row['starship_class'] ?? ''),
                'cost_in_credits' => (int) ($row['cost_in_credits'] ?? 0),
                'length' => (float) ($row['length'] ?? 0.0),
                'max_speed' => (int) ($row['max_speed'] ?? 0),
                'crew' => htmlspecialchars($row['crew'] ?? ''),
                'passengers' => (int) ($row['passengers'] ?? 0),
                'cargo_capacity' => (int) ($row['cargo_capacity'] ?? 0),
                'consumables' => htmlspecialchars($row['consumables'] ?? ''),
                'hyperdrive_rating' => (float) ($row['hyperdrive_rating'] ?? 0.0),
                'mglt' => (int) ($row['mglt'] ?? 0),
                'created_at' => htmlspecialchars($row['created_at'] ?? ''),
                'edited_at' => htmlspecialchars($row['edited_at'] ?? ''),
                'api_url' => htmlspecialchars($row['api_url'] ?? ''),
            ];
        }
        return $ships;
    }

    public function getShipById(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT s.id, s.name, s.model, s.manufacturer_id, s.starship_class_id,
                    m.name AS manufacturer_name,
                    c.class_name AS starship_class,
                    sp.cost_in_credits, sp.length, sp.max_speed, sp.crew, sp.passengers,
                    sp.cargo_capacity, sp.consumables, sp.hyperdrive_rating, sp.mglt,
                    sa.created_at, sa.edited_at, sa.api_url
             FROM starships s
             LEFT JOIN manufacturers m ON s.manufacturer_id = m.id
             LEFT JOIN starship_classes c ON s.starship_class_id = c.id
             LEFT JOIN starship_specs sp ON s.id = sp.starship_id
             LEFT JOIN starship_api_metadata sa ON s.id = sa.starship_id
             WHERE s.id = :id"
        );
        
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        
        if (!$row) return null;
        
        return [
            'id' => $row['id'],
            'name' => htmlspecialchars($row['name'] ?? ''),
            'model' => htmlspecialchars($row['model'] ?? ''),
            'manufacturer_id' => (int)($row['manufacturer_id'] ?? 0),
            'starship_class_id' => (int)($row['starship_class_id'] ?? 0),
            'manufacturer_name' => htmlspecialchars($row['manufacturer_name'] ?? ''),
            'starship_class' => htmlspecialchars($row['starship_class'] ?? ''),
            'cost_in_credits' => (int)($row['cost_in_credits'] ?? 0),
            'length' => (float)($row['length'] ?? 0),
            'max_speed' => (int)($row['max_speed'] ?? 0),
            'crew' => htmlspecialchars($row['crew'] ?? ''),
            'passengers' => (int)($row['passengers'] ?? 0),
            'cargo_capacity' => (int)($row['cargo_capacity'] ?? 0),
            'consumables' => htmlspecialchars($row['consumables'] ?? ''),
            'hyperdrive_rating' => (float)($row['hyperdrive_rating'] ?? 0),
            'mglt' => (int)($row['mglt'] ?? 0),
            'created_at' => htmlspecialchars($row['created_at'] ?? ''),
            'edited_at' => htmlspecialchars($row['edited_at'] ?? ''),
            'api_url' => htmlspecialchars($row['api_url'] ?? '')
        ];
    }

    public function deleteShip(int $id): bool {
        $this->db->exec('BEGIN TRANSACTION');
        try {
            // CASCADE will handle related tables
            $stmt = $this->db->prepare("DELETE FROM starships WHERE id = :id");
            $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
            $stmt->execute();
            
            $this->db->exec('COMMIT');
            return true;
        } catch (\Exception $e) {
            $this->db->exec('ROLLBACK');
            return false;
        }
    }
    
    private function validateManufacturer(?int $manufacturerId): bool {
        if (!$manufacturerId) return true;
        $stmt = $this->db->prepare("SELECT id FROM manufacturers WHERE id = :id");
        $stmt->bindValue(':id', $manufacturerId, SQLITE3_INTEGER);
        return (bool) $stmt->execute()->fetchArray();
    }
    
    private function validateStarshipClass(?int $classId): bool {
        if (!$classId) return true;
        $stmt = $this->db->prepare("SELECT id FROM starship_classes WHERE id = :id");
        $stmt->bindValue(':id', $classId, SQLITE3_INTEGER);
        return (bool) $stmt->execute()->fetchArray();
    }
    
    private function isNameUnique(string $name, ?int $excludeId = null): bool {
        $sql = "SELECT id FROM starships WHERE name = :name";
        if ($excludeId) {
            $sql .= " AND id != :id";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        if ($excludeId) {
            $stmt->bindValue(':id', $excludeId, SQLITE3_INTEGER);
        }
        return !$stmt->execute()->fetchArray();
    }

    public function getAllManufacturers(): array {
        $result = $this->db->query("SELECT id, name FROM manufacturers ORDER BY name");
        $manufacturers = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $manufacturers[] = $row;
        }
        return $manufacturers;
    }
    
    public function getAllStarshipClasses(): array {
        $result = $this->db->query("SELECT id, class_name FROM starship_classes ORDER BY class_name");
        $classes = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $classes[] = $row;
        }
        return $classes;
    }
    public function updateShip(Ship $ship): bool {
        // Validate foreign keys and unique constraints
        if (!$this->validateManufacturer($ship->manufacturer_id)) {
            throw new \InvalidArgumentException("Invalid manufacturer_id");
        }
        if (!$this->validateStarshipClass($ship->starship_class_id)) {
            throw new \InvalidArgumentException("Invalid starship_class_id");
        }
        if (!$this->isNameUnique($ship->name, $ship->id)) {
            throw new \InvalidArgumentException("Ship name must be unique");
        }


        $this->db->exec('BEGIN TRANSACTION');
        try {
            // Update main starship info
            $stmt = $this->db->prepare(
                "UPDATE starships 
                 SET name = :name, 
                     model = :model, 
                     manufacturer_id = :manufacturer_id,
                     starship_class_id = :starship_class_id 
                 WHERE id = :id"
            );
            $stmt->bindValue(':id', $ship->id, SQLITE3_INTEGER);
            $stmt->bindValue(':name', htmlspecialchars(strip_tags($ship->name)), SQLITE3_TEXT);
            $stmt->bindValue(':model', htmlspecialchars(strip_tags($ship->model)), SQLITE3_TEXT);
            $stmt->bindValue(':manufacturer_id', $ship->manufacturer_id, SQLITE3_INTEGER);
            $stmt->bindValue(':starship_class_id', $ship->starship_class_id, SQLITE3_INTEGER);
            $stmt->execute();
    
            // Update specifications
            $stmt = $this->db->prepare(
                "UPDATE starship_specs 
                 SET cost_in_credits = :cost, 
                     length = :length,
                     max_speed = :speed,
                     crew = :crew,
                     passengers = :passengers,
                     cargo_capacity = :cargo,
                     consumables = :consumables,
                     hyperdrive_rating = :hyperdrive,
                     mglt = :mglt
                 WHERE starship_id = :id"
            );
            $stmt->bindValue(':id', $ship->id, SQLITE3_INTEGER);
            $stmt->bindValue(':cost', $ship->cost_in_credits, SQLITE3_INTEGER);
            $stmt->bindValue(':length', $ship->length, SQLITE3_FLOAT);
            $stmt->bindValue(':speed', $ship->max_speed, SQLITE3_INTEGER);
            $stmt->bindValue(':crew', $ship->crew, SQLITE3_TEXT);
            $stmt->bindValue(':passengers', $ship->passengers, SQLITE3_INTEGER);
            $stmt->bindValue(':cargo', $ship->cargo_capacity, SQLITE3_INTEGER);
            $stmt->bindValue(':consumables', $ship->consumables, SQLITE3_TEXT);
            $stmt->bindValue(':hyperdrive', $ship->hyperdrive_rating, SQLITE3_FLOAT);
            $stmt->bindValue(':mglt', $ship->mglt, SQLITE3_INTEGER);
            $stmt->execute();
    
            // Update metadata
            $stmt = $this->db->prepare(
                "UPDATE starship_api_metadata 
                 SET edited_at = datetime('now'),
                     api_url = :api_url
                 WHERE starship_id = :id"
            );
            $stmt->bindValue(':id', $ship->id, SQLITE3_INTEGER);
            $stmt->bindValue(':api_url', $ship->api_url, SQLITE3_TEXT);
            $stmt->execute();
    
            $this->db->exec('COMMIT');
            return true;
        } catch (Exception $e) {
            $this->db->exec('ROLLBACK');
            return false;
        }
    }
    
    public function addManufacturer(string $name): int {
        // Begin transaction
        $this->db->exec('BEGIN TRANSACTION');
        try {
            // Check if manufacturer already exists
            $stmt = $this->db->prepare("SELECT id FROM manufacturers WHERE name = :name");
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $result = $stmt->execute()->fetchArray();
            
            if ($result) {
                $this->db->exec('ROLLBACK');
                return $result['id'];
            }
            
            // Insert new manufacturer
            $stmt = $this->db->prepare("INSERT INTO manufacturers (name) VALUES (:name)");
            $stmt->bindValue(':name', htmlspecialchars(strip_tags($name)), SQLITE3_TEXT);
            $stmt->execute();
            
            $newId = $this->db->lastInsertRowID();
            $this->db->exec('COMMIT');
            return $newId;
            
        } catch (\Exception $e) {
            $this->db->exec('ROLLBACK');
            throw $e;
        }
    }
    
    public function addStarshipClass(string $className): int {
        // Begin transaction
        $this->db->exec('BEGIN TRANSACTION');
        try {
            // Check if class already exists
            $stmt = $this->db->prepare("SELECT id FROM starship_classes WHERE class_name = :name");
            $stmt->bindValue(':name', $className, SQLITE3_TEXT);
            $result = $stmt->execute()->fetchArray();
            
            if ($result) {
                $this->db->exec('ROLLBACK');
                return $result['id'];
            }
            
            // Insert new class
            $stmt = $this->db->prepare("INSERT INTO starship_classes (class_name) VALUES (:name)");
            $stmt->bindValue(':name', htmlspecialchars(strip_tags($className)), SQLITE3_TEXT);
            $stmt->execute();
            
            $newId = $this->db->lastInsertRowID();
            $this->db->exec('COMMIT');
            return $newId;
            
        } catch (\Exception $e) {
            $this->db->exec('ROLLBACK');
            throw $e;
        }
    }

    public function addShip(Ship $ship): bool {
        if (!$this->validateManufacturer($ship->manufacturer_id)) {
            throw new \InvalidArgumentException("Invalid manufacturer_id");
        }
        if (!$this->validateStarshipClass($ship->starship_class_id)) {
            throw new \InvalidArgumentException("Invalid starship_class_id");
        }
        if (!$this->isNameUnique($ship->name)) {
            throw new \InvalidArgumentException("Ship name must be unique");
        }
        $this->db->exec('BEGIN TRANSACTION');

        try {
            // Insert main starship info
            $stmt = $this->db->prepare(
                "INSERT INTO starships (name, model, manufacturer_id, starship_class_id)
                 VALUES (:name, :model, :manufacturer_id, :starship_class_id)"
            );
            $stmt->bindValue(':name', htmlspecialchars(strip_tags($ship->name)), SQLITE3_TEXT);
            $stmt->bindValue(':model', htmlspecialchars(strip_tags($ship->model)), SQLITE3_TEXT);
            $stmt->bindValue(':manufacturer_id', $ship->manufacturer_id, SQLITE3_INTEGER);
            $stmt->bindValue(':starship_class_id', $ship->starship_class_id, SQLITE3_INTEGER);
            $stmt->execute();
            
            $shipId = $this->db->lastInsertRowID();
    
            // Insert specifications
            $stmt = $this->db->prepare(
                "INSERT INTO starship_specs 
                 (starship_id, cost_in_credits, length, max_speed, crew, passengers,
                  cargo_capacity, consumables, hyperdrive_rating, mglt)
                 VALUES 
                 (:id, :cost, :length, :speed, :crew, :passengers,
                  :cargo, :consumables, :hyperdrive, :mglt)"
            );
            $stmt->bindValue(':id', $shipId, SQLITE3_INTEGER);
            $stmt->bindValue(':cost', $ship->cost_in_credits, SQLITE3_INTEGER);
            $stmt->bindValue(':length', $ship->length, SQLITE3_FLOAT);
            $stmt->bindValue(':speed', $ship->max_speed, SQLITE3_INTEGER);
            $stmt->bindValue(':crew', $ship->crew, SQLITE3_TEXT);
            $stmt->bindValue(':passengers', $ship->passengers, SQLITE3_INTEGER);
            $stmt->bindValue(':cargo', $ship->cargo_capacity, SQLITE3_INTEGER);
            $stmt->bindValue(':consumables', $ship->consumables, SQLITE3_TEXT);
            $stmt->bindValue(':hyperdrive', $ship->hyperdrive_rating, SQLITE3_FLOAT);
            $stmt->bindValue(':mglt', $ship->mglt, SQLITE3_INTEGER);
            $stmt->execute();
    
            // Insert metadata
            $stmt = $this->db->prepare(
                "INSERT INTO starship_api_metadata (starship_id, created_at, edited_at, api_url)
                 VALUES (:id, datetime('now'), datetime('now'), :api_url)"
            );
            $stmt->bindValue(':id', $shipId, SQLITE3_INTEGER);
            $stmt->bindValue(':api_url', $ship->api_url, SQLITE3_TEXT);
            $stmt->execute();
    
            $this->db->exec('COMMIT');
            return true;
        } catch (Exception $e) {
            $this->db->exec('ROLLBACK');
            return false;
        }
    }
}