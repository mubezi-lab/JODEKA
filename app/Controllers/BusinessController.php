<?php

class BusinessController extends Controller
{
    public function index($slug = null)
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/');
        }

        if (!$slug) {
            die('Business not specified');
        }

        $slug = strtolower($slug);
        $user = $_SESSION['user'];

        $viewPath = BASE_PATH . "/views/business/{$slug}.php";

        if (!file_exists($viewPath)) {
            die('Business page not found');
        }

        // Admin & Manager
        if ($user['role'] === 'admin' || $user['role'] === 'manager') {

            $this->view("business/{$slug}", [
                'pageTitle' => ucfirst($slug) . ' Dashboard'
            ], 'admin');

            return;
        }

        // STAFF ACCESS (FIXED)
        if ($user['role'] === 'staff' && !empty($user['department_id'])) {

            $db = new Database();

            $dept = $db->query(
                "SELECT name FROM departments WHERE id = ?",
                [$user['department_id']]
            )->fetch();

            if (!$dept || strtolower($dept['name']) !== $slug) {
                die('Access Denied');
            }

            $products = [];

            if ($slug === 'bandani') {

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