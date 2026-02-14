<?php

// class DashboardController extends Controller {

//     public function index()
//     {
//         RoleMiddleware::requireLogin();

//         $role = $_SESSION['user']['role'];

//         if ($role === 'admin') {
//             $this->view('dashboard/admin');
//         } 
//         elseif ($role === 'manager') {
//             $this->view('dashboard/manager');
//         } 
//         else {
//             $this->view('dashboard/staff');
//         }
//     }
// }







class DashboardController extends Controller {

    public function index()
    {
        // Hakikisha user amelogin
        RoleMiddleware::requireLogin();

        // Chukua role
        $role = $_SESSION['user']['role'] ?? null;

        if (!$role) {
            $this->redirect('/login');
        }

        // Admin Dashboard
        if ($role === 'admin') {

            // Sample data (baadaye tutatoa DB)
            $data = [
                'pageTitle' => 'Admin Dashboard',
                'userName'  => $_SESSION['user']['name'] ?? 'Admin'
            ];

            $this->view('dashboard/admin', $data, 'admin');
        }

        // Manager Dashboard
        elseif ($role === 'manager') {
            $this->view('dashboard/manager');
        }

        // Employee Dashboard
        elseif ($role === 'employee') {
            $this->view('dashboard/staff');
        }

        // Kama role haijulikani
        else {
            $this->redirect('/login');
        }
    }
}