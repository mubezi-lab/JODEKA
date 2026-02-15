<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $pageTitle ?? 'Staff Panel' ?></title>
<link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>

<header class="topbar">
    <div class="logo">JODEKA - <?= htmlspecialchars($_SESSION['user']['department']) ?></div>

    <div class="header-right">
        <div class="notification">
            🔔
            <span class="badge">1</span>
        </div>

        <div class="user">
            <?= htmlspecialchars($_SESSION['user']['name']) ?>
        </div>
    </div>
</header>

<div class="layout">

    <!-- Staff Sidebar (Minimal) -->
    <aside class="sidebar">
        <a href="/<?= strtolower($_SESSION['user']['department']) ?>">Dashboard</a>
        <a href="/logout">Logout</a>
    </aside>

    <main class="content">
        <?php require $view; ?>
    </main>

</div>

</body>
</html>