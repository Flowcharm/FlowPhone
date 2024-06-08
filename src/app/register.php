<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/public/styles/login-register.css">
    <script src="/public/js/register.js" defer type="module"></script>
    <?php include_once "../includes/common_head.php" ?>
</head>

<body>
    <div class="login">
        <h1>Register</h1>
        <form id="register-form">
            <input type="text" name="name" placeholder="Juan">
            <input type="email" name="email" placeholder="example@email.com">
            <input type="password" name="password" placeholder="*****">
            <input type="submit" id="register-form-submit" value="Register">
        </form>
        <div class="action-links">
            <a href="./login.php">Already have an account? Log in!</a>
        </div>
    </div>
</body>

</html>