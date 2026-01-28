<?php

namespace App\Core;

class Controller {
    protected function view($view, $data = [], $layout = null) {
        // Extract data keys as variables called $key
        extract($data);

        // Path to the view file
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View not found: " . $view);
        }

        if ($layout) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();

            $layoutPath = __DIR__ . '/../Views/layouts/' . $layout . '.php';
            if (file_exists($layoutPath)) {
                require $layoutPath;
            } else {
                die("Layout not found: " . $layout);
            }
        } else {
            require $viewPath;
        }
    }
    
    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}
