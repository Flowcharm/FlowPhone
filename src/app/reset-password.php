<?php
$token = $_GET["token"];

if (!$token) {
    header("Location: ./login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="/public/styles/login-register.css">
    <script src="/public/js/reset-password.js" defer type="module"></script>
    <?php include_once "../includes/common_head.php" ?>
</head>

<body>
    <?php include_once "../includes/header.php" ?>
    <div class="login">
        <h1>Reset Password</h1>
        <form id="reset-password-form">
            <input type="password" name="password" id="password" placeholder="New password">
            <input type="password" name="confirm-password" id="confirm-password" placeholder="Repeat password">
            <input type="submit" id="reset-password-form-submit" value="Reset password">
        </form>
        <div class="action-links">
            <a href="./login.php">Remember your password? Log in!</a>
        </div>
    </div>
    <?php include_once "../includes/footer.php" ?>
</body>

</html>