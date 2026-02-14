<?php

class AuthController extends Controller {

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$this->validateCSRF()) {
                die("Invalid CSRF Token");
            }

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = new User($this->db);
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {

                session_regenerate_id(true);

                unset($_SESSION['csrf_token']); // clear after success

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];

                $this->redirect('dashboard');

            } else {

                $this->view('auth/login', [
                    'error' => 'Invalid email or password',
                    'csrf' => $this->csrfToken()
                ]);
            }

        } else {

            $this->view('auth/login', [
                'csrf' => $this->csrfToken()
            ]);
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('login');
    }
}