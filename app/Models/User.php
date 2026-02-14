<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->query(
            "SELECT * FROM users WHERE email = ?",
            [$email]
        );

        return $stmt->fetch();
    }
}