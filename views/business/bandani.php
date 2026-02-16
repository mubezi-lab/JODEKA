<h2>Bandani Dashboard</h2>

<div class="tabs">
    <button class="tab-btn active" data-tab="overview">Overview</button>
    <button class="tab-btn" data-tab="newOrder">New Order</button>
</div>


<!-- ================= OVERVIEW ================= -->
<section class="tab-content active" id="overview">

    <!-- MONTHLY SALES CARD -->
    <div class="card">
        <h3>Monthly Sales (June)</h3>
        <p style="font-size:18px;font-weight:bold;">TZS 1,250,000</p>

        <div class="chart-container">
            <canvas id="monthlyBreakdownChart"></canvas>
        </div>
    </div>


    <!-- DEBTS CARD -->
    <div class="card">
        <h3>Current Debts</h3>
        <p style="font-size:18px;font-weight:bold;">TZS 320,000</p>
    </div>


    <!-- WEEKLY SALES -->
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

        <form>
            <input type="text" placeholder="Product Name" required>
            <button type="submit">Submit Order</button>
        </form>
    </div>
</section>