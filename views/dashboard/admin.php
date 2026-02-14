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

<section class="tab-content" id="addUser">
<div class="card">
<h3>Add User</h3>
<form>
<input type="text" placeholder="Full Name">
<input type="text" placeholder="Username">
<select>
<option>Employee</option>
<option>Manager</option>
<option>Admin</option>
</select>
<button type="submit">Save</button>
</form>
</div>
</section>

<section class="tab-content" id="stock">
<div class="card">
<h3>Daily Stock Entry</h3>
<form>
<input type="text" placeholder="Product Name">
<input type="number" placeholder="Mwazo">
<input type="number" placeholder="Pokea">
<input type="number" placeholder="Baki">
<input type="number" placeholder="Bei ya Kimoja">
<button>Save Stock</button>
</form>
</div>
</section>