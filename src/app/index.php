<?php
require_once '../repositories/Phone_repository.php';

// TODO
$user = "root";
$password = "1234";
$database = "flowphone";
$host = "localhost";
$port = 3360;

$connection = new mysqli($host, $user, $password, $database, $port);

$phoneRepository = new PhoneRepository($connection);

$phones = $phoneRepository->getAllPhones();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Shop</title>
    <?php // TODO: include_once "..\includes\common_head.php";
    ?>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .card {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
        }
        .card-body {
            display: flex;
            padding: 20px;
            flex: 1;
        }
        .card-body .left-column, .card-body .right-column {
            flex: 1;
        }
        .card-body .left-column {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card-body .left-column p {
            margin: 5px 0;
            font-size: 1em;
            color: #777;
        }
        .card-body .left-column .stars {
            font-size: 1.5em; /* Bigger stars */
            color: #ffd700; /* Gold color for stars */
        }
        .card-body .right-column {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-end;
        }
        .card-body .right-column .price {
            font-size: 1.4em;
            font-weight: bold;
            color: #e74c3c;
        }
        .card-body .right-column .taxes {
            font-size: 0.8em;
            color: #777;
            margin-top: -20px; /* Adjust to move it closer to the price */
        }
        .card-body .right-column .button-container {
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            margin-top: auto;
        }
        button.addCart {
            padding: 10px 20px;
            font-size: 1em;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }
        .card-footer button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (empty($phones)): ?>
        <h1>No phones available</h1>
    <?php else: foreach ($phones as $phone): ?>
        <div class='card'>
            <img src='<?= $phone->getImageUrl() ?>' alt='<?= $phone->getBrand() . " " . $phone->getModel() ?>'>
            <div class='card-body'>
                <div class='left-column'>
                    <h3><?= $phone->getBrand() . " " . $phone->getModel() ?></h3>
                    <p>Screen Size: <?= $phone->getScreenSizeInch() ?> in</p>
                    <p>Storage: <?= $phone->getStorageGb() ?> GB</p>
                    <p>OS: <?= $phone->getOs() ?></p>
                    <p class='stars'><?= str_repeat('★', $phone->getRatings()) . str_repeat('☆', 5 - $phone->getRatings()) ?></p>
                </div>
                <div class='right-column'>
                    <p class='price'>€<?= $phone->getPriceEur() ?></p>
                    <p class='taxes'>Taxes Included</p>
                    <div class='button-container'>
                        <button class='addCart' onclick='buyProduct(<?= $phone->getId() ?>)'>Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; endif; ?>
</div>

<script>
    function buyProduct(id) {
        alert('Product with ID ' + id + ' has been added to your cart.');
        // Here you can add further functionality to handle the purchase
    }
</script>

</body>
</html>
