<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JODEKA SYSTEM</title>

    <!-- Viewport (MUHIMU kwa iPhone) -->
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="login-wrapper">

    <div class="login-card">

        <!-- HEADER -->
        <div class="login-header">
            <i class="fa-solid fa-building"></i>
            <h1>JODEKA</h1>
        </div>

        <!-- ERROR -->
        <?php if (!empty($error)): ?>
            <div class="alert">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form method="POST" action="/auth/login">

            <!-- CSRF TOKEN -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">

            <!-- EMAIL -->
            <div class="floating-group">
                <i class="fa-regular fa-envelope input-icon"></i>
                <input type="email" name="email" placeholder=" " required>
                <label>Email Address</label>
            </div>

            <!-- PASSWORD -->
            <div class="floating-group">
                <i class="fa-solid fa-lock input-icon"></i>
                <input type="password" name="password" placeholder=" " required>
                <label>Password</label>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn-login">
                Login
            </button>

        </form>

    </div>

</div>

</body>
</html>