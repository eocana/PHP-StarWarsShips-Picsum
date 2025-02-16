<?php
// Cargar la librería de autoload de Composer
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno desde el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Obtener la ruta de la base de datos desde las variables de entorno (.env)
// Si no está definida, se usa la ruta por defecto 'database/starships.db'
$dbPath = __DIR__ . '/' . ($_ENV['DB_PATH'] ?? 'database/starships.db');

try {
    // Obtener el directorio donde se almacenará la base de datos
    $dbDir = dirname($dbPath);
    
    // Verificar si el directorio existe, si no, crearlo con permisos 0755
    if (!file_exists($dbDir)) {
        mkdir($dbDir, 0755, true);
    }

    // Establecer conexión con la base de datos SQLite
    $db = new SQLite3($dbPath);

    // Habilitar el uso de claves foráneas en SQLite
    $db->exec('PRAGMA foreign_keys = ON;');

    // Cargar el esquema SQL desde el archivo 'schema.sql'
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    
    // Ejecutar el esquema SQL para crear las tablas necesarias
    $db->exec($schema);

    // Mensaje de confirmación si todo salió bien
    echo "Base de datos creada exitosamente en: $dbPath\n";
    
    // Cerrar la conexión con la base de datos
    $db->close();
} catch (Exception $e) {
    // Capturar y mostrar cualquier error que ocurra durante la creación de la base de datos
    echo "Error al crear la base de datos: " . $e->getMessage() . "\n";
    exit(1);
}
