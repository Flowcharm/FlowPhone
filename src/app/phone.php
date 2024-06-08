<?php
declare(strict_types=1);

require_once __DIR__."/../models/db_manager.php";
require_once __DIR__."/../repositories/phone_repository.php";
require_once __DIR__."/../controllers/phone_controller.php";
require_once __DIR__."/../helpers/get_env.php";

$user = "root";
$password = "1234";
$database = "flowphone";
$host = "localhost";
$port = 3360;

$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"));

$phone_repository = new PhoneRepository($db);
$phone_controller = new PhoneController($phone_repository);

$phone = null;

try {
    $id = $_GET["id"];
    if (!isset($id)) {
        throw new Exception("Phone id is required", 400);
    }
    $phone = $phone_controller->get_by_id((int)$id);
    if (!$phone) {
        throw new Exception("Phone not found", 404);
    }
} catch (Exception $e) {
    http_response_code($e->getCode());
    die($e->getMessage());
}

$phoneName = $phone->get_brand() . " " . $phone->get_model();
$title = $phoneName . " - FlowPhone";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <?php include_once "..\includes\common_head.php"; ?>
    <link rel="stylesheet" href="/public/styles/phone-page.css">
    <script type="module" src="/public/js/phone.js" defer></script>
</head>
<body>
    <?php // TODO: include_once "..\includes\nav.php"; 
    ?>
    <main class="phone">
        <div class="hero">
            <img src="<?= $phone->get_image_url() ?>" alt="<?= $phoneName ?>" class="hero__image">
            <div class="hero__title">
                <h1 class="hero__name"><?= $phoneName ?></h1>
                <div class="hero__stars">
                    <?php for ($i = 0; $i < $phone->get_ratings(); $i++): ?>
                        <span class="hero__star star filled"><?php include "..\includes\icons\star.php"; ?></span>
                    <?php endfor; ?>
                    <?php for ($i = $phone->get_ratings(); $i < 5; $i++): ?>
                        <span class="hero__star star"><?php include "../includes/icons/star.php"; ?></span>
                    <?php endfor; ?>
                    <span class="hero__rating"><?= $phone->get_ratings(); ?></span>
                </div>
            </div>
        </div>
        <div class="action-btns">
            <p>Price: <span><?= $phone->get_price_eur() ?>€</span></p>
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
                <li>Brand <?= $phone->get_brand() ?></li>
                <li>Model <?= $phone->get_model() ?></li>
                <li>Release year <?= $phone->get_release_year() ?></li>
                <li>Screen size <?= $phone->get_sreen_size_inch() ?> inches</li>
                <li>Battery capacity <?= $phone->get_battery_capacity_mah() ?> mAh</li>
                <li>RAM <?= $phone->get_ram_gb() ?> GB</li>
                <li>Storage <?= $phone->get_storage_gb() ?> GB</li>
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
                            <td><?= $phone->get_brand() ?></td>
                        </tr>
                        <tr>
                            <td>Model</td>
                            <td><?= $phone->get_model() ?></td>
                        </tr>
                        <tr>
                            <td>Release Year</td>
                            <td><?= $phone->get_release_year() ?></td>
                        </tr>
                        <tr>
                            <td>Screen Size</td>
                            <td><?= $phone->get_sreen_size_inch() ?> pulgadas</td>
                        </tr>
                        <tr>
                            <td>Battery Capacity</td>
                            <td><?= $phone->get_battery_capacity_mah() ?> mAh</td>
                        </tr>
                        <tr>
                            <td>RAM</td>
                            <td><?= $phone->get_ram_gb() ?> GB</td>
                        </tr>
                        <tr>
                            <td>Storage</td>
                            <td><?= $phone->get_storage_gb() ?> GB</td>
                        </tr>
                        <tr>
                            <td>Operating System</td>
                            <td><?= $phone->getOs() ?></td>
                        </tr>
                        <tr>
                            <td>Rating</td>
                            <td><?= $phone->get_ratings() ?></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td><?= $phone->get_price_eur() ?>€</td>
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
</body>
</html>
