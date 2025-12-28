<?php
declare(strict_types=1);

namespace App\Core;

class Router {
    private array $routes = [];

    // Rotas GET
    public function get(string $path, array $handler): void {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void {
        $this->routes['POST'][$path] = $handler;
    }

    public function run(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Ajuste para ignorar subpastas (como /php_valuation/public)
        $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $route = str_replace($basePath, '', $uri) ?: '/';

        if (isset($this->routes[$method][$route])) {
            [$controllerClass, $methodName] = $this->routes[$method][$route];

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                    return;
                }
            }
        }

        http_response_code(404);
        echo "<h1>404 - Rota não encontrada</h1>";
    }
}