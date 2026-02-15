<?php

class BarController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/');
        }

        $user = $_SESSION['user'];

        // Admin & Manager wanaweza kuona kwa admin layout
        if ($user['role'] === 'admin' || $user['role'] === 'manager') {
            $this->view('dashboard/bar', [
                'pageTitle' => 'Bar Dashboard'
            ], 'admin');
            return;
        }

        // Staff wa Bar
        if ($user['role'] === 'staff' && $user['department'] === 'Bar') {
            $this->view('dashboard/bar', [
                'pageTitle' => 'Bar Dashboard'
            ], 'staff'); // 🔥 tofauti hapa
            return;
        }

        die('Access Denied');
    }
}