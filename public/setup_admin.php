<?php

require_once __DIR__ . '/../app/Core/Database.php';

$db = new Database();

echo "<h2>Creating Admin User...</h2>";

$name = "Admin";
$email = "admin@jodeka.com";
$password = "admin123"; // Badilisha baada ya login
$role = "admin";

// Check if admin already exists
$check = $db->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1");

if ($check->rowCount() > 0) {
    die("<p style='color:red;'>Admin already exists! Delete this file.</p>");
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert admin
$db->query(
    "INSERT INTO users (name, email, password, role, created_at)
     VALUES (?, ?, ?, ?, NOW())",
    [$name, $email, $hashedPassword, $role]
);

echo "<p style='color:green;'>Admin created successfully!</p>";
echo "<p>Email: <b>$email</b></p>";
echo "<p>Password: <b>$password</b></p>";
echo "<hr>";
echo "<strong>IMPORTANT: DELETE setup_admin.php NOW!</strong>";