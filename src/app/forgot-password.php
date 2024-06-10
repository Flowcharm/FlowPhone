<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="/public/styles/login-register.css">
    <script src="/public/js/forgot-password.js" defer type="module"></script>
    <?php include_once "../includes/common_head.php" ?>
</head>

<body>
    <?php include_once "../includes/header.php" ?>
    <div class="login">
        <h1>Forgot Password</h1>
        <form id="forgot-password-form">
            <input type="email" name="email" placeholder="example@email.com" required>
            <input type="submit" id="forgot-password-form-submit" value="Send mail">
        </form>
        <div class="action-links">
            <a href="./login.php">Remember your password? Log in!</a>
        </div>
    </div>
    <?php include_once "../includes/footer.php" ?>
</body>

</html>