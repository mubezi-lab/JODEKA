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

        // Hakikisha view ipo
        $viewPath = BASE_PATH . "/views/business/{$slug}.php";

        if (!file_exists($viewPath)) {
            die('Business page not found');
        }

        // Admin & Manager wanaweza kuona zote
        if ($user['role'] === 'admin' || $user['role'] === 'manager') {

            $this->view("business/{$slug}", [
                'pageTitle' => ucfirst($slug) . ' Dashboard'
            ], 'admin');

            return;
        }

        // Staff lazima business yake ilingane
        if (
            $user['role'] === 'staff' &&
            strtolower($user['department']) === $slug
        ) {

            $this->view("business/{$slug}", [
                'pageTitle' => ucfirst($slug) . ' Dashboard'
            ], 'staff');

            return;
        }

        die('Access Denied');
    }

    
}