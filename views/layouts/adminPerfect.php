<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin Panel' ?></title>

    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>

<header class="topbar">

    <button id="menuToggle" class="menu-btn">☰</button>

    <div class="logo">JODEKA</div>

    <div class="header-right">

        <div class="notification">
            🔔
            <span class="badge"><?= $notificationCount ?? 3 ?></span>
        </div>

        <div class="user">
            <img src="/assets/img/user.png" alt="User">
        </div>

    </div>

</header>

<div class="layout">

    <aside class="sidebar" id="sidebar">
        <button class="close-btn" id="closeSidebar">✕</button>

        <a href="/dashboard">Dashboard</a>
        <a href="/duka">Duka</a>
        <a href="/bar">Bar</a>
        <a href="/ufugaji">Ufugaji</a>
        <a href="/kilimo">Kilimo</a>
        <a href="/rentals">Rentals</a>
        <a href="/users">Users</a>
        <a href="/stock">Stock</a>
        <a href="/reports">Reports</a>
        <a href="/alerts">Alerts</a>
        <a href="/logout">Logout</a>
    </aside>

    <main class="content">
        <?php require $view; ?>
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/assets/js/admin.js"></script>

</body>
</html>