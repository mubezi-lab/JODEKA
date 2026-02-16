<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $pageTitle ?? 'Staff Panel' ?></title>

<link rel="stylesheet" href="/assets/css/admin.css">

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<header class="topbar">

    <!-- LEFT: Staff Image + Name -->
    <div class="logo">

        <img src="/assets/img/user.png" 
             alt="User"
             class="user-avatar">

        <span class="staff-name">
            <?= htmlspecialchars($_SESSION['user']['name']) ?>
        </span>

    </div>

    <!-- RIGHT: Notification + Logout -->
    <div class="header-right">

        <div class="notification">
            <i class="fa-solid fa-bell"></i>
            <span class="badge">1</span>
        </div>

        <form method="POST" action="/logout" class="logout-form">
            <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
        </form>

    </div>

</header>

<main class="content">
    <?php require $view; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/assets/js/admin.js"></script>

</body>
</html>