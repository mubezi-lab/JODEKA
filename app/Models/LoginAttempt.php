<?php

class LoginAttempt
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Find existing login attempt by IP and email
     */
    public function find($ip, $email)
    {
        $stmt = $this->db->query(
            "SELECT * FROM login_attempts 
             WHERE ip_address = :ip 
             AND username = :username",
            [
                'ip' => $ip,
                'username' => $email
            ]
        );

        return $stmt->fetch(); // returns associative array
    }

    /**
     * Increment failed attempts
     */
    public function increment($id)
    {
        $this->db->query(
            "UPDATE login_attempts 
             SET attempts = attempts + 1 
             WHERE id = :id",
            [
                'id' => $id
            ]
        );
    }

    /**
     * Insert new failed attempt
     */
    public function insert($ip, $email)
    {
        $this->db->query(
            "INSERT INTO login_attempts (ip_address, username, attempts)
             VALUES (:ip, :username, 1)",
            [
                'ip' => $ip,
                'username' => $email
            ]
        );
    }

    /**
     * Reset attempts after success or unlock
     */
    public function reset($ip, $email)
    {
        $this->db->query(
            "DELETE FROM login_attempts 
             WHERE ip_address = :ip 
             AND username = :username",
            [
                'ip' => $ip,
                'username' => $email
            ]
        );
    }
}