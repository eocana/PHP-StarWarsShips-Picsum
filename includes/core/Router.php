<?php
namespace App\Core;

class Router {
    private static array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public static function get(string $route, callable|array $callback) {
        self::$routes['GET'][$route] = $callback;
    }

    public static function post(string $route, callable|array $callback) {
        self::$routes['POST'][$route] = $callback;
    }

    public static function put(string $route, callable|array $callback) {
        self::$routes['PUT'][$route] = $callback;
    }

    public static function delete(string $route, callable|array $callback) {
        self::$routes['DELETE'][$route] = $callback;
    }

    public static function dispatch() {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        // Soporte para métodos PUT y DELETE desde formularios
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        foreach (self::$routes[$method] as $route => $callback) {
            // Convertir parámetros {id} en expresiones regulares
            $pattern = preg_replace('/{([^}]+)}/', '([^/]+)', str_replace('/', '\/', $route));
            
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                array_shift($matches); // Quitamos el primer match (ruta completa)
                
                // Si es un controlador, instanciarlo correctamente
                if (is_array($callback)) {
                    [$controller, $method] = $callback;
                    $instance = new $controller(); // Crear instancia
                    return call_user_func_array([$instance, $method], $matches);
                }
                
                return call_user_func_array($callback, $matches);
            }
        }

        http_response_code(404);
        echo "Página no encontrada";
    }
}
