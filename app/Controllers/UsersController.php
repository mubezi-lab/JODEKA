<?php

class UsersController extends Controller
{
    /**
     * Store new user from Admin Dashboard tab
     */
    public function store()
    {
        // Only admin can create users
        $this->middleware('RoleMiddleware')->handle(['admin']);

        // Must be POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin');
        }

        // Validate CSRF
        if (!$this->validateCSRF()) {
            die("Invalid CSRF Token");
        }

        $name          = trim($_POST['name'] ?? '');
        $email         = trim($_POST['email'] ?? '');
        $password      = $_POST['password'] ?? '';
        $role          = $_POST['role'] ?? '';
        $department_id = $_POST['department_id'] ?? null;

        // Basic validation
        if (!$name || !$email || !$password || !$role) {
            $_SESSION['form_error'] = "All required fields must be filled.";
            $this->redirect('admin');
        }

        // Email format validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['form_error'] = "Invalid email format.";
            $this->redirect('admin');
        }

        $userModel = $this->model('User');

        // Check duplicate email
        if ($userModel->emailExists($email)) {
            $_SESSION['form_error'] = "Email already exists.";
            $this->redirect('admin');
        }

        // Professional Rule:
        // Admin & Manager can have NULL department
        // Staff must have department

        if ($role === 'staff' && empty($department_id)) {
            $_SESSION['form_error'] = "Staff must be assigned to a department.";
            $this->redirect('admin');
        }

        // Create user
        $userModel->create([
            'name'          => $name,
            'email'         => $email,
            'password'      => password_hash($password, PASSWORD_DEFAULT),
            'role'          => $role,
            'department_id' => $department_id ?: null
        ]);

        $_SESSION['form_error'] = "User created successfully.";
        $this->redirect('admin');
    }
}