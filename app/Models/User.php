<?php

class User {

    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function findByEmail($email)
    {
        return $this->db
            ->query("SELECT * FROM users WHERE email = ?", [$email])
            ->fetch(PDO::FETCH_ASSOC);
    }
}