<?php

class AuthController extends Controller
{
    /**
     * Default route → http://jodeka.business/
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
     * Handle Login
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

        if (empty($email) || empty($password)) {
            $this->view('auth/login', [
                'error' => 'Email and Password are required',
                'csrf'  => $this->csrfToken()
            ]);
            return;
        }

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {

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

            $this->view('auth/login', [
                'error' => 'Invalid email or password',
                'csrf'  => $this->csrfToken()
            ]);
        }
    }

    /**
     * Central Redirect Logic
     */
    private function redirectUser($user)
    {
        // Admin
        if ($user['role'] === 'admin') {
            $this->redirect('admin');
        }

        // Manager
        if ($user['role'] === 'manager') {
            $this->redirect('manager');
        }

        // Staff (Only specific departments have dashboards)
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
                    // Staff without assigned dashboard
                    session_destroy();
                    die('No dashboard assigned to your department.');
            }
        }

        // Fallback
        $this->redirect('auth/index');
    }

    /**
     * Logout
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