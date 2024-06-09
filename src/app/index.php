<?php
require_once __DIR__.'/../repositories/phone_repository.php';
require_once __DIR__.'/../models/db_manager.php';
require_once __DIR__.'/../helpers/get_env.php';

$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME") );

$phone_repository = new PhoneRepository($db);

$charged_default_phones = 10;
$phones = $phone_repository->get_all($limit = $charged_default_phones);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Shop</title>
    <link rel="stylesheet" href="/public/styles/index-page.css">
    <?php include_once "../includes/common_head.php" ?>
</head>

<body>
    <?php include_once "../includes/header.php" ?>

    <div id="phones" class="container">
        <?php if (empty($phones)): ?>
        <h1>No phones available</h1>
        <?php else: ?>
        <?php foreach ($phones as $phone): ?>
        <a href='./phone.php?id=<?= $phone->get_id() ?>' class='card'>
            <img src='<?= $phone->get_image_url() ?>' alt='<?= $phone->get_brand() . " " . $phone->get_model() ?>'>
            <div class='card-body'>
                <div class='left-column'>
                    <h3><?= $phone->get_brand() . " " . $phone->get_model() ?></h3>
                    <p>Screen Size: <?= $phone->get_screen_size_inch() ?> in</p>
                    <p>Storage: <?= $phone->get_storage_gb() ?> GB</p>
                    <p>OS: <?= $phone->get_os() ?></p>
                    <div class="stars">
                        <?php for ($i = 0; $i < $phone->get_ratings(); $i++): ?>
                            <span class="star filled"><?php include "..\includes\icons\star.php"; ?></span>
                        <?php endfor; ?>
                        <?php for ($i = $phone->get_ratings(); $i < 5; $i++): ?>
                            <span class="star"><?php include "../includes/icons/star.php"; ?></span>
                        <?php endfor; ?>
                        <span class="hero__rating"><?= $phone->get_ratings(); ?></span>
                    </div>
                </div>
                <div class='right-column'>
                    <p class='price'>€<?= $phone->get_price_eur() ?></p>
                    <p class='taxes'>Taxes Included</p>
                    <div class='button-container'>
                        <button class='addCart' onclick='buyProduct(<?= $phone->get_id() ?>)'>Add to Cart</button>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
        <!-- Loading skeleton -->
        <div class='card skeleton'>
            <div class='card-body'>
                <div class='left-column'>
                    <h3>Brand Model</h3>
                    <p>Screen Size: 6.5 in</p>
                    <p>Storage: 128 GB</p>
                    <p>OS: Android</p>
                    <div class="stars">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <span class="star"><?php include "..\includes\icons\star.php"; ?></span>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class='right-column'>
                    <p class='price'>€500</p>
                    <p class='taxes'>Taxes Included</p>
                    <div class='button-container'>
                        <button class='addCart'>Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php include_once "../includes/footer.php" ?>
</body>

</html>
