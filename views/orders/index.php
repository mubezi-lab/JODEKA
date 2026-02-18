<h2>Orders Management</h2>

<?php if (empty($orders)): ?>
    <div class="card">
        <p>No orders available.</p>
    </div>
<?php endif; ?>


<?php foreach ($orders as $order): ?>

<div class="card" style="margin-bottom:20px;">

    <!-- ORDER HEADER -->
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <strong>Department:</strong> <?= htmlspecialchars($order['department_name']) ?><br>
            <strong>Date:</strong> <?= date('d M Y', strtotime($order['created_at'])) ?>
        </div>

        <div>
            <strong>Status:</strong>
            <?php if ($order['status'] === 'pending'): ?>
                <span style="color:orange;">Pending</span>
            <?php elseif ($order['status'] === 'approved'): ?>
                <span style="color:green;">Approved</span>
            <?php else: ?>
                <span style="color:red;">Rejected</span>
            <?php endif; ?>
        </div>
    </div>

    <hr style="margin:15px 0;">

    <?php if ($order['status'] === 'pending'): ?>

        <!-- APPROVE FORM -->
        <form method="POST" action="/orders/approve/<?= $order['id'] ?>">

            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Package</th>
                        <th>Qty (Packages)</th>
                        <th>Cost / Package</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                    $db = new Database();
                    $items = $db->query("
                        SELECT oi.*, p.name 
                        FROM order_items oi
                        JOIN products p ON oi.product_id = p.id
                        WHERE oi.order_id = ?
                    ", [$order['id']])->fetchAll();
                ?>

                <?php foreach ($items as $item): ?>

                    <?php
                        $packaging = $db->query("
                            SELECT package_type 
                            FROM product_packaging
                            WHERE product_id = ?
                        ", [$item['product_id']])->fetchAll();
                    ?>

                    <tr>
                        <td>
                            <?= htmlspecialchars($item['name']) ?>
                        </td>

                        <td>
                            <select name="package[<?= $item['product_id'] ?>]" required>
                                <?php foreach ($packaging as $pkg): ?>
                                    <option value="<?= $pkg['package_type'] ?>">
                                        <?= htmlspecialchars($pkg['package_type']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>

                        <td>
                            <input type="number"
                                   step="0.01"
                                   name="quantity[<?= $item['product_id'] ?>]"
                                   required>
                        </td>

                        <td>
                            <input type="number"
                                   step="0.01"
                                   name="cost[<?= $item['product_id'] ?>]"
                                   required>
                        </td>
                    </tr>

                <?php endforeach; ?>

                </tbody>
            </table>

            <div style="margin-top:15px; display:flex; gap:10px;">
                <button type="submit">Approve & Purchase</button>
            </div>

        </form>

        <form method="POST" action="/orders/reject/<?= $order['id'] ?>" style="margin-top:10px;">
            <button type="submit" style="background:#dc2626;">Reject</button>
        </form>

    <?php else: ?>

        <p>This order has been <?= htmlspecialchars($order['status']) ?>.</p>

    <?php endif; ?>

</div>

<?php endforeach; ?>