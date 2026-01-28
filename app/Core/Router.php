<?php

namespace App\Core;

class Router {
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function dispatch($uri, $method) {
        // Parse URL to ignore query strings
        $path = parse_url($uri, PHP_URL_PATH);
        
        if (isset($this->routes[$method][$path])) {
            $action = $this->routes[$method][$path];
            
            // If Closure
            if (is_callable($action)) {
                call_user_func($action);
                return;
            }
            
            // If Array [Class, Method]
            if (is_array($action)) {
                $controllerClass = $action[0];
                $methodName = $action[1];
                
                $controller = new $controllerClass();
                $controller->$methodName();
                return;
            }
            
        } else {
            http_response_code(404);
            // Simple 404
            echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>
                    <meta charset='UTF-8'>
                    <h1 style='color: #64748b;'>404</h1>
                    <p style='color: #94a3b8;'>Caminho neural não encontrado.</p>
                  </div>";
        }
    }
}
