<?php
require_once __DIR__ . "/../helpers/protect_route.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account | <?php echo $user->get_name() ?></title>
    <link rel="stylesheet" href="/public/styles/account.css">
    <script src="/public/js/account.js" defer type="module"></script>
    <?php include_once "../includes/common_head.php" ?>
</head>

<body>
    <header>
        <h1>Account details</h1>
        <h2>Hi, <span id="account-title"><?php echo $user->get_name() ?></span>!</h2>
        <p>Here are your account details:</p>
    </header>
    <form id="account-form">
        <div class="field">
            <label for="name">Name:</label>
            <input type="text" id="account-form-name" name="name" value="<?php echo $user->get_name() ?>">
        </div>
        <?php if (!$user->get_isGoogleAccount()): ?>
            <div class="field">
                <label for="email">Email:</label>
                <input type="email" id="email" name="account-form-email" value="<?php echo $user->get_email() ?>">
            </div>
            <div class="field">
                <label for="password">Password:</label>
                <input type="password" id="password" name="current-password" placeholder="Current password">
                <input type="password" id="new-password" name="new-password" placeholder="New password">
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm password">
            </div>
        <?php endif; ?>
        <input type="submit" value="Update" id="account-form-submit">
    </form>
</body>

</html>