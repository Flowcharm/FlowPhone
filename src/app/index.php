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
    <script src="/public/js/index.js" type="module" defer></script>
    <head>

    <body>
        <?php include_once "../includes/header.php" ?>
        <div class="main-container">
            <section class="hero-search">
                <form action="" class="hero-search__form" id="search-form">
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
                        <input type="number" name="limit" class="hero-search__input" placeholder="Limit" id="search-limit">
                    </div>

                    <div class="hero-search__buttons">
                        <button class="btn" type="reset">Reset</button>
                        <button class="btn" type="submit">Search</button>
                    </div>
                </form>
                <div id="search-results-container" class="hidden">
                    <div>
                        <h2>Search Results</h2>
                        <p id="search-results"></p>
                    </div>
                    <div id="list-phones-search" class="list-phones">
                        <!-- Loading skeleton -->
                        <a href="#" class="preview-phone-card skeleton">
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
                        </a>
                    </div>
                </div>
            </section>

            <section id="phones-container" class="phones-container">
                <div>
                    <h2>Top Phones</h2>
                    <p>Check out our top phones</p>
                </div>
                <div id="list-phones-main" class="list-phones">
                    <?php if (empty($phones)): ?>
                    <h1>No phones available</h1>
                    <?php else: ?>
                    <?php foreach ($phones as $phone): ?>
                    <a href="/src/app/phone.php?id=<?= $phone->get_id() ?>" class="preview-phone-card">
                        <img src="<?= $phone->get_image_url() ?>"
                            alt="<?= $phone->get_brand() . " " . $phone->get_model() ?>"
                            class="preview-phone-card__phone-image">
                        <div class="preview-phone-card__phone-info">
                            <h3 class="preview-phone-card__phone-name">
                                <?= $phone->get_brand() . " " . $phone->get_model() ?>
                            </h3>
                            <p class="preview-phone-card__phone-price">EUR <?= $phone->get_price_eur() ?><span
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
                        <div class="preview-phone-card__phone-buttons">
                            <button class="preview-phone-card__phone-btn-buy">Buy</button>
                            <button class="preview-phone-card__phone-btn-cart">
                                <span
                                    class="preview-phone-card__shop-cart"><?php include "../includes/icons/shopping_cart.php"; ?></span>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </a>
                    <?php endforeach; ?>
                    <!-- Loading skeleton -->
                    <a href="#" class="preview-phone-card skeleton">
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
                    </a>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php include_once "../includes/footer.php" ?>
    </body>

</html>
