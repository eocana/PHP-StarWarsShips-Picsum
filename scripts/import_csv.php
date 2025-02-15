<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Conectar a SQLite
$dbPath = $_ENV['DB_PATH'] ?? 'database/starships.db';
$db = new SQLite3($dbPath);

// Leer el archivo CSV
$csvFile = __DIR__ . '/../naves.csv';
if (!file_exists($csvFile)) {
    die("Error: El archivo CSV no existe.\n");
}

$handle = fopen($csvFile, 'r');
if ($handle === false) {
    die("Error: No se pudo abrir el archivo CSV.\n");
}

// Omitir la primera fila (encabezados)
fgetcsv($handle, 1000, ';');

while (($data = fgetcsv($handle, 1000, ';')) !== false) {
    list($name, $model, $manufacturer, $cost, $length, $max_speed, $crew, $passengers, $cargo, $consumables, $hyperdrive, $mglt, $starship_class, $created_at, $edited_at, $api_url) = $data;
    
    // Limpiar valores
    $cost = is_numeric($cost) ? $cost : 'NULL';
    $length = is_numeric(str_replace(',', '.', $length)) ? str_replace(',', '.', $length) : 'NULL';
    $max_speed = is_numeric($max_speed) ? $max_speed : 'NULL';
    $crew = SQLite3::escapeString($crew);
    $passengers = is_numeric($passengers) ? $passengers : 'NULL';
    $cargo = is_numeric($cargo) ? $cargo : 'NULL';
    $consumables = SQLite3::escapeString($consumables);
    $hyperdrive = is_numeric($hyperdrive) ? $hyperdrive : 'NULL';
    $mglt = is_numeric($mglt) ? $mglt : 'NULL';
    
    // Insertar fabricante evitando duplicados
    $db->exec("INSERT INTO manufacturers (name) SELECT '$manufacturer' WHERE NOT EXISTS (SELECT 1 FROM manufacturers WHERE name = '$manufacturer')");
    $manufacturer_id = $db->querySingle("SELECT id FROM manufacturers WHERE name = '$manufacturer'");
    
    // Insertar clase de nave evitando duplicados
    $db->exec("INSERT INTO starship_classes (class_name) SELECT '$starship_class' WHERE NOT EXISTS (SELECT 1 FROM starship_classes WHERE class_name = '$starship_class')");
    $class_id = $db->querySingle("SELECT id FROM starship_classes WHERE class_name = '$starship_class'");
    
    // Insertar nave
    $db->exec("INSERT INTO starships (name, model, manufacturer_id, starship_class_id) VALUES ('$name', '$model', $manufacturer_id, $class_id)");
    $starship_id = $db->querySingle("SELECT id FROM starships WHERE name = '$name'");
    
    // Insertar especificaciones
    $db->exec("INSERT INTO starship_specs (starship_id, cost_in_credits, length, max_speed, crew, passengers, cargo_capacity, consumables, hyperdrive_rating, mglt) VALUES ($starship_id, $cost, $length, $max_speed, '$crew', $passengers, $cargo, '$consumables', $hyperdrive, $mglt)");
    
    // Insertar metadatos de la API
    $db->exec("INSERT INTO starship_api_metadata (starship_id, created_at, edited_at, api_url) VALUES ($starship_id, '$created_at', '$edited_at', '$api_url')");
}

fclose($handle);
echo "Datos importados correctamente en SQLite.\n";
?>
