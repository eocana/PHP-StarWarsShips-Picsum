<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Obtener la ruta de la base de datos desde .env
$dbPath = $_ENV['DB_PATH'] ?? 'database/starships.db';

try {
    // Conectar a SQLite
    $db = new SQLite3($dbPath);

    // Habilitar claves foráneas
    $db->exec('PRAGMA foreign_keys = ON;');

    // Crear tablas según el esquema SQL
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    $db->exec($schema);

    echo "Base de datos creada exitosamente en: $dbPath\n";
} catch (Exception $e) {
    echo "Error al crear la base de datos: " . $e->getMessage() . "\n";
}

?>
