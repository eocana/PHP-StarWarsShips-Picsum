<?php
// Cargar la librería de autoload de Composer
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno desde el archivo .env ubicado en el directorio raíz
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Obtener la ruta de la base de datos desde .env o usar la ruta predeterminada
$projectRoot = dirname(__DIR__); // Directorio raíz del proyecto
$dbPath = $projectRoot . '/' . ($_ENV['DB_PATH'] ?? 'database/starships.db');

try {
    // Establecer conexión con la base de datos SQLite
    $db = new SQLite3($dbPath);

    // Definir la ruta del archivo CSV a importar
    $csvFile = __DIR__ . '/../naves.csv';

    // Verificar si el archivo CSV existe
    if (!file_exists($csvFile)) {
        die("Error: El archivo CSV no existe.\n");
    }

    // Intentar abrir el archivo CSV para lectura
    $handle = fopen($csvFile, 'r');
    if ($handle === false) {
        die("Error: No se pudo abrir el archivo CSV.\n");
    }

    // Omitir la primera fila, que contiene los encabezados
    fgetcsv($handle, 1000, ';');

    // Leer cada fila del CSV e insertarla en la base de datos
    while (($data = fgetcsv($handle, 1000, ';')) !== false) {
        list($name, $model, $manufacturer, $cost, $length, $max_speed, $crew, $passengers, $cargo, $consumables, $hyperdrive, $mglt, $starship_class, $created_at, $edited_at, $api_url) = $data;
        
        // Limpiar y validar los valores antes de insertarlos en la base de datos
        $cost = is_numeric($cost) ? $cost : 'NULL';
        $length = is_numeric(str_replace(',', '.', $length)) ? str_replace(',', '.', $length) : 'NULL';
        $max_speed = is_numeric($max_speed) ? $max_speed : 'NULL';
        $crew = SQLite3::escapeString($crew);
        $passengers = is_numeric($passengers) ? $passengers : 'NULL';
        $cargo = is_numeric($cargo) ? $cargo : 'NULL';
        $consumables = SQLite3::escapeString($consumables);
        $hyperdrive = is_numeric($hyperdrive) ? $hyperdrive : 'NULL';
        $mglt = is_numeric($mglt) ? $mglt : 'NULL';
        
        // Insertar el fabricante si no existe en la tabla manufacturers
        $db->exec("INSERT INTO manufacturers (name) 
                   SELECT '$manufacturer' 
                   WHERE NOT EXISTS (SELECT 1 FROM manufacturers WHERE name = '$manufacturer')");
        $manufacturer_id = $db->querySingle("SELECT id FROM manufacturers WHERE name = '$manufacturer'");
        
        // Insertar la clase de la nave si no existe en la tabla starship_classes
        $db->exec("INSERT INTO starship_classes (class_name) 
                   SELECT '$starship_class' 
                   WHERE NOT EXISTS (SELECT 1 FROM starship_classes WHERE class_name = '$starship_class')");
        $class_id = $db->querySingle("SELECT id FROM starship_classes WHERE class_name = '$starship_class'");
        
        // Insertar la nave en la tabla starships
        $db->exec("INSERT INTO starships (name, model, manufacturer_id, starship_class_id) 
                   VALUES ('$name', '$model', $manufacturer_id, $class_id)");
        $starship_id = $db->querySingle("SELECT id FROM starships WHERE name = '$name'");
        
        // Insertar las especificaciones de la nave en la tabla starship_specs
        $db->exec("INSERT INTO starship_specs (starship_id, cost_in_credits, length, max_speed, crew, passengers, cargo_capacity, consumables, hyperdrive_rating, mglt) 
                   VALUES ($starship_id, $cost, $length, $max_speed, '$crew', $passengers, $cargo, '$consumables', $hyperdrive, $mglt)");
        
        // Insertar los metadatos de la API en la tabla starship_api_metadata
        $db->exec("INSERT INTO starship_api_metadata (starship_id, created_at, edited_at, api_url) 
                   VALUES ($starship_id, '$created_at', '$edited_at', '$api_url')");
    }

} catch (Exception $e) {
    // Manejo de errores: mostrar mensaje y detener la ejecución
    die("Error: " . $e->getMessage() . "\n");
}

// Cerrar el archivo CSV después de la importación
fclose($handle);

// Confirmar que la importación se realizó con éxito
echo "Datos importados correctamente en SQLite.\n";
?>
