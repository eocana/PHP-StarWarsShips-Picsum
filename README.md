# Star Wars y Picsum

## 📜 Descripción

Este proyecto es una aplicación web desarrollada en **PHP** con **SQLite** que permite gestionar una base de datos de naves espaciales. Proporciona funcionalidades para listar, agregar, editar y eliminar naves mediante un sistema basado en rutas y controladores.
Aparte también descarga un csv de picsum

## 🛠 Tecnologías Utilizadas

- **PHP** (sin framework, arquitectura MVC simple)
- **SQLite** (base de datos ligera)
- **Composer** (gestión de dependencias)
- **Dotenv** (manejo de variables de entorno)

## 📂 Estructura del Proyecto

```
ACTUASOLUTIONS
│── database
│   │── schema.sql        # Esquema de la base de datos
│   │── starships.db      # Base de datos SQLite
│── includes
│   │── controllers
│   │   │── ShipController.php  # Controlador de naves
│   │   │── PicsumController.php  # Controlador de Picsum
│   │── core
│   │   │── Router.php         # Sistema de rutas
│   │── models
│   │   │── Ship.php           # Modelo de nave
│   │   │── ShipRepository.php # Repositorio de datos
│   │   │── PicsumDownloader.php # Modelo para descargar imágenes de Picsum
│   │── views
│   │   │── layouts
│   │   │── ships
│   │   │── picsum
│   │── db.php                 # Conexión con la base de datos
│── public
│   │── index.php              # Punto de entrada de la app
│   │── setup.php              # Script de configuración inicial
│── scripts
│   │── import_csv.php         # Importador de datos desde CSV
│── vendor                     # Dependencias de Composer
│── .env                        # Variables de entorno
│── .gitignore                  # Archivos ignorados en Git
│── composer.json               # Configuración de Composer
│── migrations.php              # Script de migraciones
│── naves.csv                   # Archivo de datos CSV
```

## ⚙️ Instalación y Configuración

1. **Clonar el repositorio:**
   ```sh
   git clone https://github.com/eocana/actuasolutions_PT
   cd actuasolutions_PT
   ```
2. **Instalar dependencias:**
   ```sh
   composer install
   ```
3. **Configurar variables de entorno:**
   Crear un archivo `.env` en la raíz del proyecto con el siguiente contenido:
   ```ini
   DB_PATH=database/starships.db
   ```
4. **Configurar la base de datos:**

Hay dos opciones desde la web o siguiendo los siguientes pasos:

   Ejecutar el siguiente comando para crear la base de datos y cargar el esquema:
   ```sh
   php migrations.php
   ```
5. **Importar datos desde CSV:**
   ```sh
   php scripts/import_csv.php
   ```

## Uso

Acceder a la aplicación desde el navegador:
   ```
   http://localhost:9999
   ```

### 📌 Endpoints principales:
- `GET /ships` → Listar naves
- `GET /ships/show/{id}` → Mostrar detalles de una nave
- `GET /ships/edit/{id}` → Editar una nave
- `POST /ships/store` → Guardar una nueva nave
- `POST /ships/update/{id}` → Actualizar una nave
- `POST /ships/delete/{id}` → Eliminar una nave
- `GET /picsum` → Página de descarga de imágenes de Picsum
- `POST /picsum/download` → Descargar imágenes de Picsum en formato CSV

## 🗄️ Estructura de la Base de Datos

El esquema de la base de datos se define en el archivo `schema.sql`. Las tablas principales son:
- **manufacturers**: Almacena los fabricantes de las naves.
- **starship_classes**: Almacena las clases de las naves.
- **starships**: Almacena la información básica de las naves.
- **starship_specs**: Almacena las especificaciones técnicas de las naves.
- **starship_api_metadata**: Almacena los metadatos de la API de las naves.

## 🎛️ Controladores

- **ShipController**: Maneja las solicitudes relacionadas con las naves espaciales.
- **PicsumController**: Maneja las solicitudes relacionadas con la descarga de imágenes de Picsum.

## 🏗️ Modelos

- **Ship**: Representa una nave espacial.
- **ShipRepository**: Maneja la interacción con la base de datos para las naves espaciales.
- **PicsumDownloader**: Descarga y convierte datos de imágenes de Picsum a CSV.

## 🖥️ Vistas

Las vistas se encuentran en el directorio `views` y están organizadas en subdirectorios según su funcionalidad:

- **layouts**: Contiene las plantillas comunes como `header.php` y `footer.php`.
- **ships**: Contiene las vistas relacionadas con las naves espaciales.
- **picsum**: Contiene las vistas relacionadas con la descarga de imágenes de Picsum.

## 🛤️ Rutas

Las rutas se definen en el archivo `Router.php` y se registran en el archivo `index.php`.

## 📜 Scripts

- **import_csv.php**: Importa datos de naves desde un archivo CSV a la base de datos.
- **migrations.php**: Crea la base de datos y carga el esquema inicial.

