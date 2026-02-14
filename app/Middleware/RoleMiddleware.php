<?php

class RoleMiddleware {

    public static function requireLogin()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: login");
            exit;
        }
    }

    public static function requireRole($role)
    {
        self::requireLogin();

        if ($_SESSION['user']['role'] !== $role) {
            http_response_code(403);
            die("Access Denied");
        }
    }
}