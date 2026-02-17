<h2>Order #<?= $order['id'] ?></h2>

<div class="card">

    <p><strong>Department:</strong> <?= htmlspecialchars($order['department_name']) ?></p>
    <p><strong>Requested By:</strong> <?= htmlspecialchars($order['requested_by_name']) ?></p>
    <p><strong>Date:</strong> <?= $order['created_at'] ?></p>
    <p><strong>Status:</strong> <?= ucfirst($order['status']) ?></p>

</div>

<div class="card">

    <h3>Order Items</h3>

    <form method="POST" action="/orders/update/<?= $order['id'] ?>">

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td>
                            <input 
                                type="number" 
                                name="quantities[<?= $item['id'] ?>]" 
                                value="<?= $item['quantity'] ?>" 
                                min="1"
                            >
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <br>

        <button type="submit" name="action" value="approve">
            Approve
        </button>

        <button type="submit" name="action" value="reject" style="background:red;">
            Reject
        </button>

    </form>

</div>