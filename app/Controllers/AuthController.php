<?php

class AuthController extends Controller
{
    /**
     * ============================================================
     * INDEX
     * Shows login page or redirects logged user
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

        // ===============================
        // BRUTE FORCE PROTECTION
        // ===============================
        $attemptModel = $this->model('LoginAttempt');
        $attempt = $attemptModel->find($ip, $email);

        if ($attempt && $attempt['attempts'] >= 5) {

            $lastAttempt = strtotime($attempt['last_attempt']);
            $lockTime = 10 * 60;

            if (time() - $lastAttempt < $lockTime) {
                $this->view('auth/login', [
                    'error' => 'Too many failed attempts. Try again in 10 minutes.',
                    'csrf'  => $this->csrfToken()
                ]);
                return;
            } else {
                $attemptModel->reset($ip, $email);
            }
        }

        // ===============================
        // VERIFY USER
        // ===============================
        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {

            $attemptModel->reset($ip, $email);

            session_regenerate_id(true);
            unset($_SESSION['csrf_token']);

            // 🔥 IMPORTANT FIX: store department_id not department name
            $_SESSION['user'] = [
                'id'            => $user['id'],
                'name'          => $user['name'],
                'email'         => $user['email'],
                'role'          => $user['role'],
                'department_id' => $user['department_id'] ?? null
            ];

            $this->redirectUser($_SESSION['user']);

        } else {

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
     * ROLE BASED REDIRECT
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

        if ($user['role'] === 'staff' && $user['department_id']) {

            // Get department name safely
            $db = new Database();
            $dept = $db->query(
                "SELECT name FROM departments WHERE id = ?",
                [$user['department_id']]
            )->fetch();

            if (!$dept) {
                session_destroy();
                die('No dashboard assigned to your department.');
            }

            $this->redirect(strtolower($dept['name']));
        }

        $this->redirect('auth/index');
    }

    /**
     * ============================================================
     * LOGOUT
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