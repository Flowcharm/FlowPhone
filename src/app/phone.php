<?php
declare(strict_types=1);

include_once "../repositories/phone_repository.php";
include_once "../controllers/phone_controller.php";

// TODO
$user = "root";
$password = "1234";
$database = "flowphone";
$host = "localhost";
$port = 3360;

$connection = new mysqli($host, $user, $password, $database, $port);

$phoneRepository = new PhoneRepository($connection);
$phoneController = new PhoneController($phoneRepository);

$phone = null;

try {
    $id = $_GET["id"];
    if (!isset($id)) {
        throw new Exception("Phone id is required", 400);
    }
    $phone = $phoneController->getPhoneById((int)$id);
    if (!$phone) {
        throw new Exception("Phone not found", 404);
    }
} catch (Exception $e) {
    http_response_code($e->getCode());
    die($e->getMessage());
}

$phoneName = $phone->getBrand() . " " . $phone->getModel();
$title = $phoneName . " - FlowPhone";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <?php include_once "..\includes\common_head.php"; 
    ?>
    <link rel="stylesheet" href="/public/styles/phone-page.css">
</head>
<body>
    <?php // TODO: include_once "..\includes\nav.php"; 
    ?>
    <main class="phone">
        <div class="hero">
            <img src="<?= $phone->getImageUrl() ?>" alt="<?= $phoneName ?>" class="hero__image">
            <div class="hero__title">
                <h1 class="hero__name"><?= $phoneName ?></h1>
                <div class="hero__stars">
                    <?php for ($i = 0; $i < $phone->getRatings(); $i++): ?>
                        <span class="hero__star star filled"><?php include "..\includes\icons\star.php"; ?></span>
                    <?php endfor; ?>
                    <?php for ($i = $phone->getRatings(); $i < 5; $i++): ?>
                        <span class="hero__star star"><?php include "../includes/icons/star.php"; ?></span>
                    <?php endfor; ?>
                    <span class="hero__rating"><?= $phone->getRatings(); ?></span>
                </div>
            </div>
        </div>
        <div class="action-btns">
            <p>Price: <span><?= $phone->getPriceEur() ?>€</span></p>
            <button type="button" class="card">Buy</button>
            <button type="button" class="card">
                <span class="action-btns__icon action-btns__icon-car">
                    <?php include "../includes/icons/shopping_cart.php"; ?>
                </span>
                Add to cart
            </button>
        </div>
        <div class="info-section">
            <h2 class="section-title">Specifications</h2>
            <ul class="info-list">
                <li>Brand <?= $phone->getBrand() ?></li>
                <li>Model <?= $phone->getModel() ?></li>
                <li>Release year <?= $phone->getReleaseYear() ?></li>
                <li>Screen size <?= $phone->getScreenSizeInch() ?> inches</li>
                <li>Battery capacity <?= $phone->getBatteryCapacityMah() ?> mAh</li>
                <li>RAM <?= $phone->getRamGb() ?> GB</li>
                <li>Storage <?= $phone->getStorageGb() ?> GB</li>
                <li>OS <?= $phone->getOs() ?></li>
            </ul>
            <a href="#comparator">Show more details...</a>
        </div>
    </main>
    <section id="more-phones" class="more-phones">
        <h2 class="section-title">Similar devices</h2>
        <!-- TODO: Generate phone cards via PHP -->

        <!-- Example of phone card -->
        <div id="list-more-phones" class="phone-list">
            <a href="phone.php?id=15" class="phone-card">
                <img src="/public/images/phones/apple_iphone11.webp" alt="iPhone 11 preview" class="phone-card__image">
                <div class="phone-card__info">
                    <h3 class="phone-card__name">iPhone 11</h3>
                    <p class="phone-card__price">809€</p>
                    <div class="phone-card__stars">
                        <?php for ($i = 0; $i < 4; $i++): ?>
                            <span class="phone-card__star star filled"> <?php include "../includes/icons/star.php"; ?></span>
                        <?php endfor; ?>
                        <span class="phone-card__star star"> 
                            <?php include "../includes/icons/star.php"; ?>
                        </span>
                    </div>
                </div>
            </a>
            <a href="phone.php?id=5" class="phone-card">
                <img src="/public/images/phones/apple_iphone12.webp" alt="iPhone 12 preview" class="phone-card__image">
                <div class="phone-card__info">
                    <h3 class="phone-card__name">iPhone 12</h3>
                    <p class="phone-card__price">809€</p>
                    <div class="phone-card__stars">
                        <?php for ($i = 0; $i < 4; $i++): ?>
                            <span class="phone-card__star star filled"> <?php include "../includes/icons/star.php"; ?></span>
                        <?php endfor; ?>
                        <span class="phone-card__star star"> 
                            <?php include "../includes/icons/star.php"; ?>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </section>
    <section id="comparator" class="comparator">
        <h2 class="section-title comparator__title">Compare with another phone</h2>
        <div class="comparator__table-root card">
            <div class="comparator__table-container">
                <table class="table-product" id="table-principal-phone">
                    <thead class="table-product__head">
                        <tr>
                            <th>Specifications</th>
                            <th id="table-principal-phone-title"><?= $phoneName ?></th>
                        </tr>
                    </thead>
                    <tbody class="table-product__body">
                        <tr>
                            <td>Brand</td>
                            <td><?= $phone->getBrand() ?></td>
                        </tr>
                        <tr>
                            <td>Model</td>
                            <td><?= $phone->getModel() ?></td>
                        </tr>
                        <tr>
                            <td>Release Year</td>
                            <td><?= $phone->getReleaseYear() ?></td>
                        </tr>
                        <tr>
                            <td>Screen Size</td>
                            <td><?= $phone->getScreenSizeInch() ?> pulgadas</td>
                        </tr>
                        <tr>
                            <td>Battery Capacity</td>
                            <td><?= $phone->getBatteryCapacityMah() ?> mAh</td>
                        </tr>
                        <tr>
                            <td>RAM</td>
                            <td><?= $phone->getRamGb() ?> GB</td>
                        </tr>
                        <tr>
                            <td>Storage</td>
                            <td><?= $phone->getStorageGb() ?> GB</td>
                        </tr>
                        <tr>
                            <td>Operating System</td>
                            <td><?= $phone->getOs() ?></td>
                        </tr>
                        <tr>
                            <td>Rating</td>
                            <td><?= $phone->getRatings() ?></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td><?= $phone->getPriceEur() ?>€</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="comparator__table-root card">
            <div class="comparator__table-container">
                <table class="table-product" id="table-second-phone">
                    <thead class="table-product__head">
                        <tr>
                            <th>Specifications</th>
                            <th class="dropdown table-product__dropdown" id="dropdown-select">
                                <button class="dropdown__btn" id="dropdown-toggle">
                                    <span id="dropdown-text" class="dropdown__text">Select a phone</span>
                                    <?php include "../includes/icons/arrow.php"; ?>
                                </button>
                                <div id="dropdown-menu" class="dropdown__content">
                                    <ul id="dropdown-list" class="dropdown__list">
                                        <li id="dropdown-list-loading" class="dropdown__option dropdown__option-loading"></li>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table-second-phone-body" class="table-product__body no-phone /*loading*/">
                        <tr>
                            <td>Brand</td>
                            <td id="second-phone-brand"></td>
                        </tr>
                        <tr>
                            <td>Model</td>
                            <td id="second-phone-model"></td>
                        </tr>
                        <tr>
                            <td>Release Year</td>
                            <td id="second-phone-release-year"></td>
                        </tr>
                        <tr>
                            <td>Screen Size</td>
                            <td id="second-phone-screen-size"></td>
                        </tr>
                        <tr>
                            <td>Battery Capacity</td>
                            <td id="second-phone-battery-capacity"></td>
                        </tr>
                        <tr>
                            <td>RAM</td>
                            <td id="second-phone-ram"></td>
                        </tr>
                        <tr>
                            <td>Storage</td>
                            <td id="second-phone-storage"></td>
                        </tr>
                        <tr>
                            <td>Operating System</td>
                            <td id="second-phone-os"></td>
                        </tr>
                        <tr>
                            <td>Rating</td>
                            <td id="second-phone-rating"></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td id="second-phone-price"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php // TODO: include_once "..\includes\footer.php";
    ?>    
    <script type="module">
        import { main } from "/public/js/phone.js";
        const phone = <?= json_encode($phone->toArray()) ?>;
        main({ principalPhone: phone });
    </script>
</body>
</html>
