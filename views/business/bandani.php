<h2>Bandani Dashboard</h2>

<div class="tabs">
    <button class="tab-btn active" data-tab="overview">Overview</button>
    <button class="tab-btn" data-tab="newOrder">New Order</button>
</div>


<!-- ================= OVERVIEW ================= -->
<section class="tab-content active" id="overview">

    <div class="card">
        <h3>Monthly Sales (June)</h3>
        <p style="font-size:18px;font-weight:bold;">TZS 1,250,000</p>

        <div class="chart-container">
            <canvas id="monthlyBreakdownChart"></canvas>
        </div>

        <div class="gauge-legend">
            <div><span class="legend-box red"></span> Salary</div>
            <div><span class="legend-box yellow"></span> Electricity</div>
            <div><span class="legend-box green-light"></span> Rent</div>
            <div><span class="legend-box green-dark"></span> Remaining</div>
        </div>
    </div>

    <div class="card">
        <h3>Current Debts</h3>
        <p style="font-size:18px;font-weight:bold;">TZS 320,000</p>
    </div>

    <div class="card">
        <h3>Weekly Sales</h3>
        <div class="chart-container">
            <canvas id="weeklySalesChart"></canvas>
        </div>
    </div>

</section>



<!-- ================= NEW ORDER ================= -->
<section class="tab-content" id="newOrder">

    <div class="card">
        <h3>Create Order</h3>

        <form method="POST" action="/orders/store">

            <table>
                <thead>
                    <tr>
                        <th style="width:60px;">Select</th>
                        <th>Product</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <input 
                                        type="checkbox"
                                        name="products[]"
                                        value="<?= $product['id'] ?>"
                                    >
                                </td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No products available</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>

            <br>
            <button type="submit">Submit Order</button>

        </form>

    </div>

</section>