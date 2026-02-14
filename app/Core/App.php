<?php

class App
{
    protected $controller = 'AuthController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // CUSTOM ROLE ROUTES
        if (!empty($url[0])) {

            switch ($url[0]) {
                case 'admin':
                case 'manager':
                case 'employee':
                    $this->controller = 'DashboardController';
                    $this->method = $url[0];
                    break;

                default:
                    $controllerName = ucfirst($url[0]) . 'Controller';
                    $controllerFile = BASE_PATH . '/app/Controllers/' . $controllerName . '.php';

                    if (file_exists($controllerFile)) {
                        $this->controller = $controllerName;
                    }
                    break;
            }
        }

        require_once BASE_PATH . '/app/Controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
        }

        $this->params = array_slice($url, 2);

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', trim($_GET['url'], '/'));
        }

        return [];
    }
}