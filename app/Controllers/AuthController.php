<?php

class AuthController extends Controller
{
    /**
     * ============================================================
     * INDEX
     * Shows login page.
     * If already logged in → redirect based on role.
     * ============================================================
     */
    public function index()
    {
        if (isset($_SESSION['user'])) {
            $this->redirectUser($_SESSION['user']);
        }

        $this->view('auth/login', [
            'csrf' => $this->csrfToken()
        ]);
    }

    /**
     * ============================================================
     * LOGIN HANDLER
     * - Validates request method
     * - Validates CSRF
     * - Applies brute force protection
     * - Verifies credentials
     * - Creates secure session
     * ============================================================
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/index');
        }

        if (!$this->validateCSRF()) {
            die("Invalid CSRF Token");
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $ip = $_SERVER['REMOTE_ADDR'];

        if (empty($email) || empty($password)) {
            $this->view('auth/login', [
                'error' => 'Email and Password are required',
                'csrf'  => $this->csrfToken()
            ]);
            return;
        }

        // ========================================================
        // BRUTE FORCE PROTECTION (Max 5 attempts, Lock 10 minutes)
        // ========================================================

        $attemptModel = $this->model('LoginAttempt');
        $attempt = $attemptModel->find($ip, $email);

        if ($attempt && $attempt['attempts'] >= 5) {

            $lastAttempt = strtotime($attempt['last_attempt']);
            $lockTime = 10 * 60; // 10 minutes

            if (time() - $lastAttempt < $lockTime) {
                $this->view('auth/login', [
                    'error' => 'Too many failed attempts. Try again in 10 minutes.',
                    'csrf'  => $this->csrfToken()
                ]);
                return;
            } else {
                // Reset after lock period passes
                $attemptModel->reset($ip, $email);
            }
        }

        // ========================================================
        // VERIFY USER CREDENTIALS
        // ========================================================

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {

            // Successful login → clear attempts
            $attemptModel->reset($ip, $email);

            session_regenerate_id(true);
            unset($_SESSION['csrf_token']);

            $_SESSION['user'] = [
                'id'         => $user['id'],
                'name'       => $user['name'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'department' => $user['department'] ?? null
            ];

            $this->redirectUser($_SESSION['user']);

        } else {

            // Failed login → increment attempts
            if ($attempt) {
                $attemptModel->increment($attempt['id']);
            } else {
                $attemptModel->insert($ip, $email);
            }

            $this->view('auth/login', [
                'error' => 'Invalid email or password',
                'csrf'  => $this->csrfToken()
            ]);
        }
    }

    /**
     * ============================================================
     * ROLE-BASED REDIRECT
     * Centralized dashboard routing
     * ============================================================
     */
    private function redirectUser($user)
    {
        if ($user['role'] === 'admin') {
            $this->redirect('admin');
        }

        if ($user['role'] === 'manager') {
            $this->redirect('manager');
        }

        if ($user['role'] === 'staff' && $user['department']) {

            switch ($user['department']) {

                case 'Bandani':
                    $this->redirect('bandani');
                    break;

                case 'Sokoni':
                    $this->redirect('sokoni');
                    break;

                case 'Stand':
                    $this->redirect('stand');
                    break;

                default:
                    session_destroy();
                    die('No dashboard assigned to your department.');
            }
        }

        $this->redirect('auth/index');
    }

    /**
     * ============================================================
     * LOGOUT
     * Securely destroys session and cookie
     * ============================================================
     */
    public function logout()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        $this->redirect('/');
    }
}