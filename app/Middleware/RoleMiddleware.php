<?php

class RoleMiddleware
{
    public function handle(array $roles)
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /auth/index");
            exit;
        }

        if (!in_array($_SESSION['user']['role'], $roles)) {
            die("Access denied");
        }
    }
}