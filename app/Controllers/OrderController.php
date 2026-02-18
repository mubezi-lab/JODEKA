<?php

class OrderController extends Controller
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database;
    }

    /* =====================================================
       INDEX → Show all pending orders (Admin / Manager)
    ===================================================== */
public function index()
{
    if (!isset($_SESSION['user']) ||
        !in_array($_SESSION['user']['role'], ['admin','manager'])) {
        die('Access Denied');
    }

    $orders = $this->db->query("
        SELECT o.*, d.name AS department_name
        FROM orders o
        JOIN departments d ON o.department_id = d.id
        ORDER BY o.created_at DESC
    ")->fetchAll();

    $this->view('orders/index', [
        'orders' => $orders
    ], 'admin');
}

    /* =====================================================
       STORE → Staff creates order
    ===================================================== */
public function store()
{
    if (!isset($_SESSION['user']) ||
        $_SESSION['user']['role'] !== 'staff') {
        die('Access Denied');
    }

    $department_id = $_SESSION['user']['department_id'] ?? null;
    $user_id       = $_SESSION['user']['id'];
    $products      = $_POST['products'] ?? [];

    if (!$department_id) {
        die('User department not found');
    }

    if (empty($products)) {
        die('No products selected');
    }

    try {

        // ===============================
        // CREATE ORDER (FIXED COLUMN NAME)
        // ===============================
        $this->db->query("
            INSERT INTO orders (
                department_id,
                requested_by,
                status
            )
            VALUES (?, ?, 'pending')
        ", [
            $department_id,
            $user_id
        ]);

        // Get last inserted order ID safely
        $order_id = $this->db->query("SELECT LAST_INSERT_ID() as id")
                             ->fetch()['id'];

        // ===============================
        // INSERT ORDER ITEMS
        // ===============================
        foreach ($products as $product_id) {

            $this->db->query("
                INSERT INTO order_items (
                    order_id,
                    product_id
                )
                VALUES (?, ?)
            ", [
                $order_id,
                $product_id
            ]);
        }

        header("Location: /" . strtolower($_SESSION['user']['department']));
        exit;

    } catch (Exception $e) {
        die("Order failed: " . $e->getMessage());
    }
}

    /* =====================================================
       APPROVE → Convert order into purchase
    ===================================================== */
public function approve($orderId)
{
    // =====================================================
    // AUTHORIZATION CHECK (Admin & Manager Only)
    // =====================================================
    if (!isset($_SESSION['user']) ||
        !in_array($_SESSION['user']['role'], ['admin', 'manager'])) {
        die('Access Denied');
    }

    try {

        // =====================================================
        // 1️⃣ FETCH ORDER
        // =====================================================
        $order = $this->db->query(
            "SELECT * FROM orders WHERE id = ?",
            [$orderId]
        )->fetch();

        if (!$order) {
            die("Order not found");
        }

        // =====================================================
        // 2️⃣ CREATE PURCHASE RECORD
        // =====================================================
        $this->db->query("
            INSERT INTO purchases (
                department_id,
                source_order_id,
                purchase_date,
                created_by
            )
            VALUES (?, ?, CURDATE(), ?)
        ", [
            $order['department_id'],
            $orderId,
            $_SESSION['user']['id']
        ]);

        // Get last inserted purchase ID safely
        $purchaseId = $this->db->query("SELECT LAST_INSERT_ID() as id")
                               ->fetch()['id'];

        // =====================================================
        // 3️⃣ INSERT PURCHASE ITEMS
        // =====================================================
        if (!isset($_POST['quantity']) || empty($_POST['quantity'])) {
            die("No purchase data submitted");
        }

        foreach ($_POST['quantity'] as $productId => $quantityPackages) {

            $packageType      = $_POST['package'][$productId] ?? null;
            $quantityPackages = (float)$quantityPackages;
            $costPerPackage   = (float)($_POST['cost'][$productId] ?? 0);

            // Default units_per_package = 1
            // (Unaweza baadaye ku-fetch kutoka product_packaging table)
            $unitsPerPackage = 1;

            $totalPieces  = $quantityPackages * $unitsPerPackage;

            $costPerPiece = $unitsPerPackage > 0
                ? $costPerPackage / $unitsPerPackage
                : 0;

            $totalCost = $quantityPackages * $costPerPackage;

            $this->db->query("
                INSERT INTO purchase_items (
                    purchase_id,
                    product_id,
                    package_type,
                    quantity_packages,
                    units_per_package,
                    total_pieces,
                    cost_per_package,
                    cost_per_piece,
                    total_cost
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ", [
                $purchaseId,
                $productId,
                $packageType,
                $quantityPackages,
                $unitsPerPackage,
                $totalPieces,
                $costPerPackage,
                $costPerPiece,
                $totalCost
            ]);
        }

        // =====================================================
        // 4️⃣ UPDATE ORDER STATUS
        // =====================================================
        $this->db->query(
            "UPDATE orders 
             SET status = 'approved',
                 approved_by = ?
             WHERE id = ?",
            [$_SESSION['user']['id'], $orderId]
        );

        // =====================================================
        // 5️⃣ REDIRECT BACK TO ORDERS
        // =====================================================
        header("Location: /orders");
        exit;

    } catch (Exception $e) {
        die("Approve failed: " . $e->getMessage());
    }
}

    /* =====================================================
       REJECT ORDER
    ===================================================== */
    public function reject($orderId)
    {
        if (!isset($_SESSION['user']) ||
            !in_array($_SESSION['user']['role'], ['admin','manager'])) {
            die('Access Denied');
        }

        $this->db->query("
            UPDATE orders SET status = 'rejected'
            WHERE id = ?
        ", [$orderId]);

        header("Location: /orders");
        exit;
    }
}