<?php
declare(strict_types=1);

include_once "../repositories/phone_repository.php";

// TODO
$user = "root";
$password = "1234";
$database = "flowphone";
$host = "localhost";
$port = 3360;

$connection = new mysqli($host, $user, $password, $database, $port);

$phoneRepository = new PhoneRepository($connection);

$phone = $phoneRepository->getPhoneById(2);

$title = $phone->getBrand() . " " . $phone->getModel()." | FlowPhone";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <?php // TODO: include_once "..\includes\common_head.php"; 
    ?>
</head>
<body>
    <h1><?= $title ?></h1>
    <img src="<?= $phone->getImageUrl() ?>" alt="<?= $title ?>">
    <p>Price: <?= $phone->getPriceEur() ?> €</p>
    <p>OS: <?= $phone->getOs() ?></p>
    <p>Screen size: <?= $phone->getScreenSizeInch() ?> inches</p>
    <p>Storage: <?= $phone->getStorageGb() ?> GB</p>
    <p>Ratings: <?= $phone->getRatings() ?></p>
    <p>Release year: <?= $phone->getReleaseYear() ?></p>
    <p>Battery capacity: <?= $phone->getBatteryCapacityMah() ?> mAh</p>
    <p>RAM: <?= $phone->getRamGb() ?> GB</p>
    <p>Camera: <?= $phone->getCameraMp() ?> MP</p>
</body>
</html>
