<?php

class OrderController extends Controller
{
    /**
     * Show all pending orders as cards
     */
    public function index()
    {
        $this->middleware('RoleMiddleware')->handle(['admin','manager']);

        $db = new Database();

        // Fetch orders pamoja na department + user
        $orders = $db->query("
            SELECT 
                o.id,
                d.name AS department,
                u.name AS requested_by,
                o.status,
                o.created_at
            FROM orders o
            JOIN departments d ON o.department_id = d.id
            JOIN users u ON o.requested_by = u.id
            ORDER BY o.id DESC
        ")->fetchAll();

        // Fetch items kwa kila order
        foreach ($orders as &$order) {
            $order['items'] = $db->query("
                SELECT oi.id, p.name, oi.quantity
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = ?
            ", [$order['id']])->fetchAll();
        }

        $this->view('orders/index', [
            'orders' => $orders
        ], 'admin');
    }

    /**
     * Approve order
     */
    public function approve($id)
    {
        $this->middleware('RoleMiddleware')->handle(['admin','manager']);

        $db = new Database();

        $db->query("
            UPDATE orders 
            SET status = 'approved', approved_by = ?
            WHERE id = ?
        ", [$_SESSION['user']['id'], $id]);

        header("Location: /orders");
        exit;
    }

    /**
     * Reject order
     */
    public function reject($id)
    {
        $this->middleware('RoleMiddleware')->handle(['admin','manager']);

        $db = new Database();

        $db->query("
            UPDATE orders 
            SET status = 'rejected'
            WHERE id = ?
        ", [$id]);

        header("Location: /orders");
        exit;
    }
}