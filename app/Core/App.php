<?php

class App
{
    protected $controller = 'AuthController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (!empty($url[0])) {

            $firstSegment = strtolower($url[0]);

            /*
            |--------------------------------------------------------------------------
            | 🔐 AUTH ROUTES
            |--------------------------------------------------------------------------
            */
            if ($firstSegment === 'login' || $firstSegment === 'logout') {

                require_once '../app/Controllers/AuthController.php';
                $controller = new AuthController;

                call_user_func_array([$controller, $firstSegment], []);
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | 👑 DASHBOARD ROUTES (ADMIN & MANAGER FIX)
            |--------------------------------------------------------------------------
            */
            if ($firstSegment === 'admin' || $firstSegment === 'manager') {

                require_once '../app/Controllers/DashboardController.php';
                $controller = new DashboardController;

                call_user_func_array([$controller, $firstSegment], []);
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | NORMAL CONTROLLER ROUTING
            |--------------------------------------------------------------------------
            */
            $controllerName = ucfirst($firstSegment) . 'Controller';
            $controllerPath = '../app/Controllers/' . $controllerName . '.php';

            if (file_exists($controllerPath)) {

                require_once $controllerPath;
                $controller = new $controllerName;

                unset($url[0]);

                $method = 'index';

                if (isset($url[1]) && method_exists($controller, $url[1])) {
                    $method = $url[1];
                    unset($url[1]);
                }

                $params = $url ? array_values($url) : [];

                call_user_func_array([$controller, $method], $params);
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | 🔥 BUSINESS FALLBACK
            |--------------------------------------------------------------------------
            */
            require_once '../app/Controllers/BusinessController.php';
            $controller = new BusinessController;

            call_user_func_array([$controller, 'index'], [$firstSegment]);
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | DEFAULT ROUTE
        |--------------------------------------------------------------------------
        */
        require_once '../app/Controllers/AuthController.php';
        $controller = new AuthController;

        call_user_func_array([$controller, 'index'], []);
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode(
                '/',
                filter_var(
                    rtrim($_GET['url'], '/'),
                    FILTER_SANITIZE_URL
                )
            );
        }

        return [];
    }
}