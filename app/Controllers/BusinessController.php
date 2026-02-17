<?php

class BusinessController extends Controller
{
    /**
     * Handle all business dashboard pages dynamically
     */
    public function index($slug = null)
    {
        // ================================
        // AUTH CHECK
        // ================================
        if (!isset($_SESSION['user'])) {
            $this->redirect('/');
        }

        if (!$slug) {
            die('Business not specified');
        }

        $slug = strtolower($slug);
        $user = $_SESSION['user'];

        // ================================
        // VERIFY VIEW EXISTS
        // ================================
        $viewPath = BASE_PATH . "/views/business/{$slug}.php";

        if (!file_exists($viewPath)) {
            die('Business page not found');
        }

        // ================================
        // ADMIN & MANAGER ACCESS
        // ================================
        if ($user['role'] === 'admin' || $user['role'] === 'manager') {

            $this->view("business/{$slug}", [
                'pageTitle' => ucfirst($slug) . ' Dashboard'
            ], 'admin');

            return;
        }

        // ================================
        // STAFF ACCESS CONTROL
        // ================================
        if (
            $user['role'] === 'staff' &&
            strtolower($user['department']) === $slug
        ) {

            $products = [];

            // Only Bandani loads products for order form
            if ($slug === 'bandani') {

                $db = new Database();

                $stmt = $db->query(
                    "SELECT id, name
                     FROM products
                     WHERE is_active = 1
                     ORDER BY name ASC"
                );

                $products = $stmt->fetchAll();
            }

            $this->view("business/{$slug}", [
                'pageTitle' => ucfirst($slug) . ' Dashboard',
                'products'  => $products ?? []
            ], 'staff');

            return;
        }

        die('Access Denied');
    }
}