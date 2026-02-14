<?php

class DashboardController extends Controller
{
    public function admin()
    {
        $this->middleware('RoleMiddleware')->handle(['admin']);

        $this->view('dashboard/admin', [], 'admin');
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