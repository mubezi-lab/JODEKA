<h2>Admin Control Center</h2>

<div class="tabs">
    <button class="tab-btn active" data-tab="overview">Overview</button>
    <button class="tab-btn" data-tab="addUser">Add User</button>
    <button class="tab-btn" data-tab="purchase">Purchase</button>
    <button class="tab-btn" data-tab="expenses">Expenses</button>
    <button class="tab-btn" data-tab="stock">Stock</button>
    <button class="tab-btn" data-tab="rentals">Rentals</button>
    <button class="tab-btn" data-tab="livestock">Livestock</button>
    <button class="tab-btn" data-tab="reports">Reports</button>
    <button class="tab-btn" data-tab="alerts">Alerts</button>
</div>

<!-- ================= OVERVIEW ================= -->
<section class="tab-content active" id="overview">
    <div class="cards">
        <div class="card"><h3>Monthly Income</h3><p>TZS 0</p></div>
        <div class="card"><h3>Monthly Expenses</h3><p>TZS 0</p></div>
        <div class="card"><h3>Profit</h3><p>TZS 0</p></div>
    </div>

    <div class="card">
        <div class="chart-container">
            <canvas id="financeChart"></canvas>
        </div>
    </div>
</section>

<!-- ================= ADD USER ================= -->
<section class="tab-content" id="addUser">
    <div class="card">
        <h3>Add User</h3>

        <?php if (!empty($error)): ?>
            <div class="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/users/store">

            <input type="hidden" name="csrf_token" value="<?= $csrf ?? '' ?>">

            <input type="text" name="name" placeholder="Full Name" required>

            <input type="email" name="email" placeholder="Email Address" required>

            <input type="password" name="password" placeholder="Password" required>

            <select name="role" required>
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="staff">Staff</option>
            </select>

            <select name="department_id">
                <option value="">Select Department (Optional for Admin/Manager)</option>

                <?php if (!empty($departments)): ?>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['id'] ?>">
                            <?= htmlspecialchars($dept['name']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <button type="submit">Save User</button>

        </form>
    </div>
</section>

<!-- ================= PURCHASE ================= -->
<section class="tab-content" id="purchase">
    <div class="card"><h3>Purchase Module</h3></div>
</section>

<!-- ================= EXPENSES ================= -->
<section class="tab-content" id="expenses">
    <div class="card"><h3>Expenses Module</h3></div>
</section>

<!-- ================= STOCK ================= -->
<section class="tab-content" id="stock">
    <div class="card">
        <h3>Daily Stock Entry</h3>
        <form>
            <input type="text" placeholder="Product Name">
            <input type="number" placeholder="Opening">
            <input type="number" placeholder="Received">
            <input type="number" placeholder="Remaining">
            <input type="number" placeholder="Price">
            <button type="submit">Save Stock</button>
        </form>
    </div>
</section>

<!-- ================= RENTALS ================= -->
<section class="tab-content" id="rentals">
    <div class="card"><h3>Rentals Module</h3></div>
</section>

<!-- ================= LIVESTOCK ================= -->
<section class="tab-content" id="livestock">
    <div class="card"><h3>Livestock Module</h3></div>
</section>

<!-- ================= REPORTS ================= -->
<section class="tab-content" id="reports">
    <div class="card"><h3>Reports Module</h3></div>
</section>

<!-- ================= ALERTS ================= -->
<section class="tab-content" id="alerts">
    <div class="card"><h3>Alerts Module</h3></div>
</section>