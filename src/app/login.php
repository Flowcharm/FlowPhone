<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="/public/styles/login-register.css">
    <script src="/public/js/login.js" defer type="module"></script>
    <?php include_once "../includes/common_head.php" ?>
</head>

<body>
    <?php include_once "../includes/header.php" ?>

    <div class="login">
        <h1>Log in</h1>
        <form id="login-form">
            <input type="email" name="email" placeholder="example@email.com" required>
            <input type="password" name="password" placeholder="*****" required>
            <input type="submit" id="login-form-submit" value="Log in">
        </form>
        <a href="/src/app/api/google-oauth.php" class="google-oauth">
            Log in with Google
            <?php include "../includes/icons/google.php" ?>
        </a>
        <div class="action-links">
            <a href="./forgot-password.php">Forgot your password?</a>
            <a href="./register.php">Don't have an account? Register!</a>
        </div>
    </div>

    <?php include_once "../includes/footer.php" ?>
</body>

</html>