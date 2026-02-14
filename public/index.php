<?php

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

session_start();

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/config/db.php';
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/app/Core/Controller.php';
require BASE_PATH . '/app/Core/App.php';

new App();