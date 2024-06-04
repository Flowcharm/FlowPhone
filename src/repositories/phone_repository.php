<?php
declare(strict_types=1);

require_once '../models/phone.php';
require_once '../interfaces/phone_interface.php';

class PhoneRepository implements IPhoneRepository {
    public function __construct(
        private mysqli $connection
    )
    { }

    public function getPhoneById(int $searchId): ?Phone {
        $sql = "SELECT id, brand, model, release_year, screen_size, battery_capacity, ram, storage, camera_mp, price, os, ratings, image_url FROM phones WHERE id = ?";

        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("i", $searchId);
        $stmt->execute();
        $stmt->bind_result($id, $brand, $model, $release_year, $screen_size, $battery_capacity, $ram, $storage, $camera, $price, $os, $ratings, $image_url);
        $stmt->fetch();

        $screen_size = (float) $screen_size;
        $price = (int) $price;

        $stmt->close();

        if ($id === null) {
            return null;
        }

        return new Phone(
            $id,
            $brand,
            $model,
            $release_year,
            $screen_size,
            $battery_capacity,
            $ram,
            $storage,
            $camera,
            $price,
            $os,
            $ratings,
            $image_url
        );
    }

    public function getAllPhones(): array {
        $sql = "SELECT id, brand, model, release_year, screen_size, battery_capacity, ram, storage, camera_mp, price, os, ratings, image_url FROM phones";

        $result = $this->connection->query($sql);

        $phones = [];

        while ($row = $result->fetch_assoc()) {
            $phone = new Phone(
                (int)$row['id'],
                $row['brand'],
                $row['model'],
                (int)$row['release_year'],
                (float)$row['screen_size'],
                (int)$row['battery_capacity'],
                (int)$row['ram'],
                (int)$row['storage'],
                (int)$row['camera_mp'],
                (float)$row['price'],
                $row['os'],
                (int)$row['ratings'],
                $row['image_url']
            );
            $phones[] = $phone;
        }

        return $phones;
    }
}
?>
