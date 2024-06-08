<?php
require_once __DIR__.'/../repositories/phone_repository.php';
require_once __DIR__.'/../models/db_manager.php';
require_once __DIR__.'/../helpers/get_env.php';

$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME") );

$phone_repository = new PhoneRepository($db);

$phones = $phone_repository->get_all();

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

    <div class="container"> <?php if (empty($phones)): ?>
            <h1>No phones available</h1>
        <?php else:
        foreach ($phones as $phone): ?>
                <div class='card'>
                    <img src='<?= $phone->get_image_url() ?>' alt='<?= $phone->get_brand() . " " . $phone->get_model() ?>'>
                    <div class='card-body'>
                        <div class='left-column'>
                            <h3><?= $phone->get_brand() . " " . $phone->get_model() ?></h3>
                            <p>Screen Size: <?= $phone->get_sreen_size_inch() ?> in</p>
                            <p>Storage: <?= $phone->get_storage_gb() ?> GB</p>
                            <p>OS: <?= $phone->getOs() ?></p>
                            <p class='stars'>
                                <?= str_repeat('★', $phone->get_ratings()) . str_repeat('☆', 5 - $phone->get_ratings()) ?></p>
                        </div>
                        <div class='right-column'>
                            <p class='price'>€<?= $phone->get_price_eur() ?></p>
                            <p class='taxes'>Taxes Included</p>
                            <div class='button-container'>
                                <button class='addCart' onclick='buyProduct(<?= $phone->get_id() ?>)'>Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; endif; ?>
    </div>

</body>

</html>