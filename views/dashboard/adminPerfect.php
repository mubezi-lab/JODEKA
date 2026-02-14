<h2>Admin Control Center</h2>

<!-- TAB NAVIGATION -->
<div class="tabs">
    <button class="tab-btn active" data-tab="overview">Overview</button>
    <button class="tab-btn" data-tab="stock">Stock</button>
    <button class="tab-btn" data-tab="rentals">Rentals</button>
    <button class="tab-btn" data-tab="livestock">Livestock</button>
    <button class="tab-btn" data-tab="reports">Reports</button>
    <button class="tab-btn" data-tab="alerts">Alerts</button>
</div>

<!-- ================= OVERVIEW ================= -->
<section class="tab-content active" id="overview">

    <div class="cards">
        <div class="card">
            <h3>Monthly Income</h3>
            <p>TZS <?= number_format($monthlyIncome ?? 0) ?></p>
        </div>

        <div class="card">
            <h3>Monthly Expenses</h3>
            <p>TZS <?= number_format($monthlyExpenses ?? 0) ?></p>
        </div>

        <div class="card">
            <h3>Profit</h3>
            <p>
                TZS <?= number_format(($monthlyIncome ?? 0) - ($monthlyExpenses ?? 0)) ?>
            </p>
        </div>
    </div>

    <div class="card">
        <h3>Finance Chart</h3>
        <canvas id="financeChart"></canvas>
    </div>

</section>

<!-- ================= STOCK ================= -->
<section class="tab-content" id="stock">

    <h3>Duka Stock Report</h3>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Tarehe</th>
                    <th>Mwazo</th>
                    <th>Pokea</th>
                    <th>Jumla</th>
                    <th>Uzawa</th>
                    <th>Baki</th>
                    <th>Kiasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01-06-2026</td>
                    <td>100</td>
                    <td>50</td>
                    <td>150</td>
                    <td>60</td>
                    <td>90</td>
                    <td>TZS 0</td>
                </tr>
            </tbody>
        </table>
    </div>

</section>

<!-- ================= RENTALS ================= -->
<section class="tab-content" id="rentals">

    <div class="card">
        <h3>Record Rental Payment</h3>
        <form method="POST" action="/rentals/pay">
            <input type="text" name="tenant" placeholder="Tenant Name" required>
            <input type="number" name="amount" placeholder="Amount Paid" required>
            <button type="submit">Save</button>
        </form>
    </div>

</section>

<!-- ================= LIVESTOCK ================= -->
<section class="tab-content" id="livestock">

    <div class="card">
        <h3>Livestock Overview</h3>
        <p>Layers: 0</p>
        <p>Kienyeji: 0</p>
        <p>Mbuzi/Ng’ombe: 0</p>
    </div>

</section>

<!-- ================= REPORTS ================= -->
<section class="tab-content" id="reports">

    <div class="card">
        <h3>Generate Report</h3>
        <form method="GET" action="/reports/generate">
            <input type="date" name="start" required>
            <input type="date" name="end" required>
            <select name="project">
                <option value="duka">Duka</option>
                <option value="bar">Bar</option>
            </select>
            <button type="submit">Generate</button>
        </form>
    </div>

</section>

<!-- ================= ALERTS ================= -->
<section class="tab-content" id="alerts">

    <div class="card">
        <ul>
            <li>📦 Order from Duka</li>
            <li>💉 Vaccination Alert</li>
            <li>⚠ Low Stock Alert</li>
            <li>🏠 Late Rent</li>
        </ul>
    </div>

</section>