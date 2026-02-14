<?php

class AuthController extends Controller
{
    /**
     * Default route → http://jodeka.business/
     */
    public function index()
    {
        // Kama user tayari ame-login, mpeleke dashboard yake
        if (isset($_SESSION['user'])) {

            switch ($_SESSION['user']['role']) {
                case 'admin':
                    $this->redirect('admin');
                    break;

                case 'manager':
                    $this->redirect('manager');
                    break;

                case 'staff':
                    $this->redirect('employee');
                    break;
            }
        }

        // Kama hajalogin, show login page
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
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role']
            ];

            // 🔥 Role-based clean redirect
            switch ($user['role']) {

                case 'admin':
                    $this->redirect('admin');
                    break;

                case 'manager':
                    $this->redirect('manager');
                    break;

                case 'staff':
                    $this->redirect('employee');
                    break;

                default:
                    $this->redirect('auth/index');
                    break;
            }

        } else {

            $this->view('auth/login', [
                'error' => 'Invalid email or password',
                'csrf'  => $this->csrfToken()
            ]);
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        session_unset();
        session_destroy();

        $this->redirect('auth/index');
    }
}