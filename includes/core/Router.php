<?php
namespace App\Core;
use App\Controllers\ShipController;
use App\Controllers\PicsumController;
/**
 * Clase Router que gestiona las rutas de la aplicación.
 * Permite registrar rutas HTTP (GET, POST, PUT, DELETE) y despachar las solicitudes a los controladores correspondientes.
 */
class Router {
    /**
     * Almacena las rutas registradas para cada método HTTP.
     */
    private static array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    /**
     * Registra una nueva ruta GET.
     *
     * @param string $route La ruta a registrar (ejemplo: '/ships/{id}').
     * @param callable|array $callback Función o controlador que manejará la petición.
     */
    public static function get(string $route, callable|array $callback) {
        self::$routes['GET'][$route] = $callback;
    }

    /**
     * Registra una nueva ruta POST.
     *
     * @param string $route La ruta a registrar.
     * @param callable|array $callback Función o controlador que manejará la petición.
     */
    public static function post(string $route, callable|array $callback) {
        self::$routes['POST'][$route] = $callback;
    }

    /**
     * Registra una nueva ruta PUT.
     *
     * @param string $route La ruta a registrar.
     * @param callable|array $callback Función o controlador que manejará la petición.
     */
    public static function put(string $route, callable|array $callback) {
        self::$routes['PUT'][$route] = $callback;
    }

    /**
     * Registra una nueva ruta DELETE.
     *
     * @param string $route La ruta a registrar.
     * @param callable|array $callback Función o controlador que manejará la petición.
     */
    public static function delete(string $route, callable|array $callback) {
        self::$routes['DELETE'][$route] = $callback;
    }

    /**
     * Despacha la solicitud actual y ejecuta la función o controlador correspondiente.
     * Analiza la URI y el método HTTP para encontrar la ruta registrada.
     */
    public static function dispatch() {
        // Obtener la URI solicitada y eliminar barras diagonales innecesarias
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        // Soporte para métodos PUT y DELETE en formularios HTML
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        // Buscar la ruta correspondiente en la lista de rutas registradas
        foreach (self::$routes[$method] as $route => $callback) {
            // Convertir parámetros {id} en expresiones regulares para hacer coincidir rutas dinámicas
            $pattern = preg_replace('/{([^}]+)}/', '([^/]+)', str_replace('/', '\/', $route));

            // Verificar si la URI coincide con la ruta registrada
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                array_shift($matches); // Eliminar el primer match (ruta completa)

                // Si el callback es un array (Controlador y método), instanciar el controlador
                if (is_array($callback)) {
                    [$controller, $method] = $callback;
                    $instance = new $controller(); // Crear una instancia del controlador
                    return call_user_func_array([$instance, $method], $matches); // Llamar al método del controlador con los parámetros extraídos
                }

                // Si es una función anónima, ejecutarla con los parámetros extraídos
                return call_user_func_array($callback, $matches);
            }
        }

        // Si no se encuentra la ruta, devolver un error 404
        http_response_code(404);
        echo "Página no encontrada";
    }
}
