<?php
session_start();

require_once __DIR__ . "/../helpers/protect_route.php";
require_once __DIR__ . "/../helpers/env.php";
require_once __DIR__ . "/../repositories/user_repository.php";
require_once __DIR__ . "/../repositories/cart_repository.php";
require_once __DIR__ . "/../models/db_manager.php";

$user_id = $_SESSION["user_id"];

$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
$cartRepository = new Cart_Repository($db);

$items = $cartRepository->get_by_user_id($user_id);
$total_price = 0;
foreach ($items as $item) {
    $total_price += $item["phone"]["price_eur"] * $item["quantity"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="/public/styles/cart.css">
    <script src="/public/js/cart.js" defer type="module"></script>
    <?php include_once "../includes/common_head.php" ?>
</head>

<body>
    <?php include_once "../includes/header.php" ?>
    <h1>Your cart</h1>

    <ul class="cart">
        <?php foreach ($items as $item): ?>
            <li>
                <img src="<?= $item["phone"]["image_url"] ?>" alt="<?= $item["phone"]["brand"] ?>">
                <div class="phone">
                    <div class="phone-details">
                        <div class="phone-title">
                            <h2><?= $item["phone"]["brand"] ?></h2>
                            <span>price: <?= $item["phone"]["price_eur"] ?>€</span>
                        </div>
                        <span>
                            x<span id="phone-quantity-<?= $item["phone"]["id"] ?>"><?= $item["quantity"] ?></span>
                        </span>
                    </div>
                    <div class="actions">
                        <button class="btn-decrease" data-quantity="<?= $item["quantity"] ?>" data-id="<?= $item["phone"]["id"] ?>"
                            data-price="<?= $item["phone"]["price_eur"] ?>">
                            <?php include "../includes/icons/minus.php" ?>
                        </button>
                        <button class="btn-remove" data-id="<?= $item["phone"]["id"] ?>"
                            data-quantity="<?= $item["quantity"] ?>" data-price="<?= $item["phone"]["price_eur"] ?>">
                            <?php include "../includes/icons/trash.php" ?>
                        </button>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3 class="total-price">Total: <span id="total"><?= number_format((float) $total_price, 0, "", "") ?></span>€</h3>

    <div class="checkout">
        <?php if ($user_id): ?>
            <button id="payment">Proceed to payment</button>
        <?php else: ?>
            <a href="/src/app/login.php" id="payment-login">Login to proceed to payment</a>
        <?php endif; ?>
    </div>


    <?php include_once "../includes/footer.php" ?>
</body>

</html>