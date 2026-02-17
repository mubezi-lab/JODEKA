<?php

class DashboardController extends Controller
{
    /**
     * Admin Dashboard
     * Handles:
     * - Role validation
     * - Department loading
     * - Pending order notifications
     */
    public function admin()
    {
        // Allow only admin
        $this->middleware('RoleMiddleware')->handle(['admin']);

        $userModel = $this->model('User');
        $departments = $userModel->getDepartments();

        $db = new Database();

        // 🔔 Count pending orders for notification badge
        $pendingCount = $db->query("
            SELECT COUNT(*) as total
            FROM orders
            WHERE status = 'pending'
        ")->fetch()['total'] ?? 0;

        // 📦 Get pending orders list (for Orders tab)
        $orders = $db->query("
            SELECT 
                o.id,
                o.status,
                o.created_at,
                d.name as department_name,
                u.name as requested_by_name
            FROM orders o
            JOIN departments d ON o.department_id = d.id
            JOIN users u ON o.requested_by = u.id
            WHERE o.status = 'pending'
            ORDER BY o.created_at DESC
        ")->fetchAll();

        $this->view('dashboard/admin', [
            'csrf' => $this->csrfToken(),
            'departments' => $departments,
            'orders' => $orders,
            'notificationCount' => $pendingCount,
            'error' => $_SESSION['form_error'] ?? null
        ], 'admin');

        unset($_SESSION['form_error']);
    }


    /**
     * Manager Dashboard
     */
    public function manager()
    {
        $this->middleware('RoleMiddleware')->handle(['manager']);

        $this->view('dashboard/manager', [], 'admin');
    }
}