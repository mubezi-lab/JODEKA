<?php

class DashboardController extends Controller
{
    public function admin()
    {
        $this->middleware('RoleMiddleware')->handle(['admin']);

        $userModel = $this->model('User');
        $departments = $userModel->getDepartments();

        $this->view('dashboard/admin', [
            'csrf' => $this->csrfToken(),
            'departments' => $departments,
            'error' => $_SESSION['form_error'] ?? null
        ], 'admin');

        unset($_SESSION['form_error']);
    }

    public function manager()
    {
        $this->middleware('RoleMiddleware')->handle(['manager']);

        $this->view('dashboard/adminPerfect', [], 'adminPerfect');
    }

    public function employee()
    {
        $this->middleware('RoleMiddleware')->handle(['staff']);

        $this->view('dashboard/staff');
    }
}