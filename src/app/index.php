<?php
require_once __DIR__ . '/../repositories/phone_repository.php';
require_once __DIR__ . '/../models/db_manager.php';
require_once __DIR__ . '/../helpers/env.php';

$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));

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
    <script src="/public/js/index.js" type="module" defer></script>

    <head>

    <body>
        <?php include_once "../includes/header.php" ?>
        <div class="main-container">
            <section class="hero-search">
                <form class="hero-search__form" id="search-form">
                    <div class="hero-search__input-container">
                        <label for="search-input">Search Phone: </label>
                        <input type="text" name="search" class="hero-search__input" placeholder="Search for phones"
                            id="search-input">
                    </div>
                    <div class="hero-search__input-container">
                        <label for="search-min-price">Min Price: </label>
                        <input type="number" name="minPrice" class="hero-search__input" placeholder="Min Price"
                            id="search-min-price">
                    </div>
                    <div class="hero-search__input-container">
                        <label for="search-max-price">Max Price: </label>
                        <input type="number" name="maxPrice" class="hero-search__input" placeholder="Max Price"
                            id="search-max-price">
                    </div>
                    <div class="hero-search__input-container">
                        <label for="search-limit">Limit: </label>
                        <input type="number" name="limit" class="hero-search__input" placeholder="Limit how many phones"
                            id="search-limit">
                    </div>

                    <div class="hero-search__buttons">
                        <button class="btn hero-search__btn-search" type="submit">Search</button>
                        <button class="btn" type="reset">Reset</button>
                    </div>
                </form>
                <div id="search-results-container" class="hidden">
                    <div>
                        <h2>Search Results</h2>
                        <p id="search-results"></p>
                    </div>
                    <div id="list-phones-search" class="list-phones">
                        <!-- Loading skeleton -->
                        <div class="preview-phone-card skeleton">
                            <div class="preview-phone-card__phone-image"></div>
                            <div class="preview-phone-card__phone-info">
                                <h3 class="preview-phone-card__phone-name"></h3>
                                <p class="preview-phone-card__phone-price"></p>
                                <div class="preview-phone-card__phone-other-info">
                                    <p class="preview-phone-card__phone-screen-size"></p>
                                    <p class="preview-phone-card__phone-ram"></p>
                                </div>
                                <div class="preview-phone-card__stars stars">

                                </div>
                            </div>
                            <div class="preview-phone-card__phone-buttons">
                                <button class="preview-phone-card__phone-btn-buy"></button>
                                <button class="preview-phone-card__phone-btn-cart">
                                    <span class="preview-phone-card__shop-cart"></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="phones-container" class="phones-container">
                <div class="title">
                    <h2>Top Phones</h2>
                    <p>Check out our top phones</p>
                </div>
                <div id="list-phones-main" class="list-phones">
                    <?php if (empty($phones)): ?>
                        <h1>No phones available</h1>
                    <?php else: ?>
                        <?php foreach ($phones as $phone): ?>
                            <div class="preview-phone-card">
                                <a class="preview-phone-card__phone-link" href="/src/app/phone.php?id=<?= $phone->get_id() ?>">
                                    <img src="<?= $phone->get_image_url() ?>"
                                        alt="<?= $phone->get_brand() . " " . $phone->get_model() ?>"
                                        class="preview-phone-card__phone-image">
                                    <div class="preview-phone-card__phone-info">
                                        <h3 class="preview-phone-card__phone-name">
                                            <?= $phone->get_brand() . " " . $phone->get_model() ?>
                                        </h3>
                                        <p class="preview-phone-card__phone-price">$ <?= $phone->get_price_eur() ?><span
                                                class="preview-phone-card__phone-price-span">Taxes Included</span></p>
                                        <div class="preview-phone-card__phone-other-info">
                                            <p class="preview-phone-card__phone-screen-size">Screen:
                                                <?= $phone->get_screen_size_inch() ?> in
                                            </p>
                                            <p class="preview-phone-card__phone-ram">RAM: <?= $phone->get_ram_gb() ?>GB</p>
                                        </div>
                                        <div class="preview-phone-card__stars stars">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <span
                                                    class="preview-phone-card__star star <?= $i < $phone->get_ratings() ? "filled" : "" ?>"><?php include "../includes/icons/star.php"; ?></span>
                                            <?php endfor; ?>
                                            <span class="preview-phone-card__rating rating"><?= $phone->get_ratings() ?></span>
                                        </div>
                                    </div>
                                </a>
                                <div class="preview-phone-card__phone-buttons">
                                    <a class="preview-phone-card__phone-btn-buy" data-id="<?= $phone->get_id() ?>"">Buy</a>
                                    <button class="preview-phone-card__phone-btn-cart">
                                        <span
                                            class="preview-phone-card__shop-cart"><?php include "../includes/icons/shopping_cart.php"; ?></span>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- Loading skeleton -->
                        <div class="preview-phone-card skeleton">
                            <div class="preview-phone-card__phone-image"></div>
                            <div class="preview-phone-card__phone-info">
                                <h3 class="preview-phone-card__phone-name"></h3>
                                <p class="preview-phone-card__phone-price"></p>
                                <div class="preview-phone-card__phone-other-info">
                                    <p class="preview-phone-card__phone-screen-size"></p>
                                    <p class="preview-phone-card__phone-ram"></p>
                                </div>
                                <div class="preview-phone-card__stars stars">

                                </div>
                            </div>
                            <div class="preview-phone-card__phone-buttons">
                                <button class="preview-phone-card__phone-btn-buy"></button>
                                <button class="preview-phone-card__phone-btn-cart">
                                    <span class="preview-phone-card__shop-cart"></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php include_once "../includes/footer.php" ?>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
</html>