<?php
    session_start();

    $role_user = $_SESSION['role'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;
?>

<header class="header">
    <nav class="header__nav">
        <div class="header__background"></div>
        <div class="header__container">
            <a class="header__brand" href="/src/app/">
                <img src="/public/images/icon-no-bg.webp" alt="Flowphone logo" class="header__logo">
                <h2 class="header__title">Flowphone</h2>
            </a>
    
            <ul class="header__links">
                <li><a class="header__link" href="/src/app/#">Home</a></li>
                <li><a class="header__link" href="/src/app/#phones">Phones</a></li>
                <li><a class="header__link" href="/src/app/cart.php">Your Cart</a></li>
    
                <?php if ($role_user === "admin"): ?>
                <li><a class="header__link" href="/admin.php">Admin Panel</a></li>
                <?php endif; ?>
    
                <li class="header__login-links">
                    <?php if ($user_id): ?>
                    <a class="header__link header__link--logout" href="/src/app/api/logout.php">Logout</a>
                    <?php else: ?>
                    <a class="header__link header__link--register" href="/src/app/register.php">Register</a>
                    <a class="header__link header__link--login" href="/src/app/login.php">Log in</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
