<h2>Pending Orders</h2>

<?php if (empty($orders)): ?>
    <div class="card">
        <p>No orders found.</p>
    </div>
<?php endif; ?>

<?php foreach ($orders as $order): ?>

<div class="card">

    <h3>Order #<?= $order['id'] ?></h3>

    <p><strong>Department:</strong> <?= htmlspecialchars($order['department']) ?></p>
    <p><strong>Requested By:</strong> <?= htmlspecialchars($order['requested_by']) ?></p>
    <p><strong>Date:</strong> <?= $order['created_at'] ?></p>
    <p><strong>Status:</strong> <?= ucfirst($order['status']) ?></p>

    <?php if (!empty($order['items'])): ?>

        <h4 style="margin-top:20px;">Order Items</h4>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="120">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>
                            <input type="number" 
                                   value="<?= $item['quantity'] ?>" 
                                   min="1">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

    <?php if ($order['status'] === 'pending'): ?>
        <div style="margin-top:15px;">
            <a href="/orders/approve/<?= $order['id'] ?>">
                <button>Approve</button>
            </a>

            <a href="/orders/reject/<?= $order['id'] ?>">
                <button style="background:red;">Reject</button>
            </a>
        </div>
    <?php endif; ?>

</div>

<?php endforeach; ?>