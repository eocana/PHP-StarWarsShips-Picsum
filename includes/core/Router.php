<?php
namespace App\Core;

class Router {
    private static array $routes = [];

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

        if (isset(self::$routes[$method][$uri])) {
            call_user_func(self::$routes[$method][$uri]);
        } else {
            http_response_code(404);
            echo "Página no encontrada";
        }
    }
}
