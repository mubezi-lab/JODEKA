<?php

class Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Load Model
     */
    protected function model($model)
    {
        $file = BASE_PATH . '/app/Models/' . $model . '.php';

        if (!file_exists($file)) {
            die("Model not found: " . $model);
        }

        require_once $file;

        return new $model();
    }

    /**
     * Load Middleware
     */
    protected function middleware($middleware)
    {
        $file = BASE_PATH . '/app/Middleware/' . $middleware . '.php';

        if (!file_exists($file)) {
            die("Middleware not found: " . $middleware);
        }

        require_once $file;

        return new $middleware();
    }

    /**
     * Render View
     */
    protected function view($path, $data = [], $layout = null)
    {
        extract($data);

        $viewFile = BASE_PATH . '/views/' . $path . '.php';

        if (!file_exists($viewFile)) {
            die("View not found: " . $path);
        }

        if ($layout !== null) {
            $layoutFile = BASE_PATH . '/views/layouts/' . $layout . '.php';

            if (!file_exists($layoutFile)) {
                die("Layout not found: " . $layout);
            }

            $view = $viewFile;
            require $layoutFile;
        } else {
            require $viewFile;
        }
    }

    protected function redirect($url)
    {
        header("Location: /" . ltrim($url, '/'));
        exit;
    }

    protected function csrfToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    protected function validateCSRF()
    {
        return isset($_POST['csrf_token'], $_SESSION['csrf_token']) &&
               hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
    }
}