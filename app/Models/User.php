<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Login: find by email (with department name)
     */
    public function findByEmail($email)
    {
        $stmt = $this->db->query(
            "SELECT users.*, departments.name AS department
             FROM users
             LEFT JOIN departments ON users.department_id = departments.id
             WHERE email = ?",
            [$email]
        );

        return $stmt->fetch();
    }

    /**
     * Check duplicate email
     */
    public function emailExists($email)
    {
        $stmt = $this->db->query(
            "SELECT id FROM users WHERE email = ?",
            [$email]
        );

        return $stmt->fetch() ? true : false;
    }

    /**
     * Create user
     */
    public function create($data)
    {
        $this->db->query(
            "INSERT INTO users (name, email, password, role, department_id)
             VALUES (?, ?, ?, ?, ?)",
            [
                $data['name'],
                $data['email'],
                $data['password'],
                $data['role'],
                $data['department_id']
            ]
        );
    }

    /**
     * Get all departments
     */
    public function getDepartments()
    {
        $stmt = $this->db->query(
            "SELECT * FROM departments ORDER BY name ASC"
        );

        return $stmt->fetchAll();
    }

    /**
     * Get all users (future use)
     */
    public function all()
    {
        $stmt = $this->db->query(
            "SELECT users.*, departments.name AS department
             FROM users
             LEFT JOIN departments ON users.department_id = departments.id
             ORDER BY users.id DESC"
        );

        return $stmt->fetchAll();
    }
}