-- Usar .env para definir la ubicación de la base de datos
PRAGMA foreign_keys = ON;

-- Crear la tabla de fabricantes
CREATE TABLE IF NOT EXISTS manufacturers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT UNIQUE NOT NULL
);

-- Crear la tabla de clases de naves
CREATE TABLE IF NOT EXISTS starship_classes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    class_name TEXT UNIQUE NOT NULL
);

-- Crear la tabla principal de naves
CREATE TABLE IF NOT EXISTS starships (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    model TEXT NOT NULL,
    manufacturer_id INTEGER,
    starship_class_id INTEGER,
    FOREIGN KEY (manufacturer_id) REFERENCES manufacturers(id),
    FOREIGN KEY (starship_class_id) REFERENCES starship_classes(id)
);

-- Crear la tabla de especificaciones técnicas
CREATE TABLE IF NOT EXISTS starship_specs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    starship_id INTEGER NOT NULL,
    cost_in_credits INTEGER NULL,
    length REAL,
    max_speed INTEGER,
    crew TEXT,
    passengers INTEGER,
    cargo_capacity INTEGER,
    consumables TEXT,
    hyperdrive_rating REAL,
    mglt INTEGER,
    FOREIGN KEY (starship_id) REFERENCES starships(id) ON DELETE CASCADE
);

-- Crear la tabla de metadatos de la API
CREATE TABLE IF NOT EXISTS starship_api_metadata (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    starship_id INTEGER NOT NULL,
    created_at TEXT,
    edited_at TEXT,
    api_url TEXT,
    FOREIGN KEY (starship_id) REFERENCES starships(id) ON DELETE CASCADE
);

-- Crear índices para optimización
CREATE INDEX IF NOT EXISTS idx_starship_name ON starships(name);
CREATE INDEX IF NOT EXISTS idx_manufacturer_name ON manufacturers(name);
CREATE INDEX IF NOT EXISTS idx_starship_class ON starship_classes(class_name);
