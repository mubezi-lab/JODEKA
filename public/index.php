<?php

// ================== SECURE SESSION SETTINGS ==================
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // weka 1 kama unatumia HTTPS

session_start();

// ================== SESSION INACTIVITY TIMEOUT ==================
$timeoutDuration = 180; // 180 seconds = 3 minutes

if (isset($_SESSION['LAST_ACTIVITY'])) {

    if (time() - $_SESSION['LAST_ACTIVITY'] > $timeoutDuration) {

        // Session expired
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        header("Location: /");
        exit;
    }
}

// Update last activity timestamp
$_SESSION['LAST_ACTIVITY'] = time();


// ================== SESSION ID REGENERATION ==================
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > 180) { // regenerate every 3 minutes
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}


// ================== APPLICATION BOOT ==================
define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/app/Core/Controller.php';
require BASE_PATH . '/app/Core/App.php';

// Start MVC
new App();