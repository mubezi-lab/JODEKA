<?php

// class Controller {

//     protected $db;

//     public function __construct()
//     {
//         $this->db = new Database();
//     }

//     protected function view($path, $data = [])
//     {
//         extract($data);
//         require BASE_PATH . "/views/" . $path . ".php";
//     }

//     protected function redirect($url)
//     {
//         header("Location: " . $url);
//         exit;
//     }

//     // ===== STABLE CSRF =====
//     protected function csrfToken()
//     {
//         if (!isset($_SESSION['csrf_token'])) {
//             $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
//         }

//         return $_SESSION['csrf_token'];
//     }

//     protected function validateCSRF()
//     {
//         if (
//             !isset($_POST['csrf']) ||
//             !isset($_SESSION['csrf_token']) ||
//             !hash_equals($_SESSION['csrf_token'], $_POST['csrf'])
//         ) {
//             return false;
//         }

//         return true;
//     }
// }




class Controller {

    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Render View
     * 
     * @param string $path   mfano: dashboard/admin
     * @param array  $data   data za kupitisha kwenye view
     * @param string|null $layout mfano: 'admin'
     */
    protected function view($path, $data = [], $layout = null)
    {
        // Extract data to variables
        if (!empty($data)) {
            extract($data, EXTR_SKIP);
        }

        // Tengeneza full path ya view
        $viewFile = BASE_PATH . "/views/" . $path . ".php";

        // Hakikisha view ipo
        if (!file_exists($viewFile)) {
            die("❌ View not found: " . $viewFile);
        }

        // Kama layout imetolewa
        if ($layout !== null) {

            $layoutFile = BASE_PATH . "/views/layouts/" . $layout . ".php";

            if (!file_exists($layoutFile)) {
                die("❌ Layout not found: " . $layoutFile);
            }

            // Variable itakayotumika ndani ya layout
            $view = $viewFile;

            require $layoutFile;

        } else {
            // Hakuna layout, render direct
            require $viewFile;
        }
    }

    /**
     * Redirect
     */
    protected function redirect($url)
    {
        header("Location: " . $url);
        exit;
    }

    /**
     * CSRF Token Generator
     */
    protected function csrfToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Validate CSRF
     */
    protected function validateCSRF()
    {
        if (
            !isset($_POST['csrf']) ||
            !isset($_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf'])
        ) {
            return false;
        }

        return true;
    }
}