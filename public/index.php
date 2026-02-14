<?php

// Secure Session Settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

session_start();

define('BASE_PATH', dirname(__DIR__));

// ===== CONFIG =====
require BASE_PATH . '/config/db.php';

// ===== CORE =====
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/app/Core/Controller.php';

// ===== MIDDLEWARE =====
require BASE_PATH . '/app/Middleware/RoleMiddleware.php';

// ===== MODELS =====
require BASE_PATH . '/app/Models/User.php';

// ===== CONTROLLERS =====
require BASE_PATH . '/app/Controllers/AuthController.php';
require BASE_PATH . '/app/Controllers/DashboardController.php';

// ===== ROUTING =====
$url = $_GET['url'] ?? 'login';

switch ($url) {

    case '':
    case 'login':
        (new AuthController())->login();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'dashboard':
        (new DashboardController())->index();
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
}