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

    public function getAllPhones(?int $limit = null, ?int $offset = null): array
    {
        $sql = "SELECT id, brand, model, release_year, screen_size, battery_capacity, ram, storage, camera_mp, price, os, ratings, image_url FROM phones";
        $params = [];
        if ($limit !== null) {
            $sql .= " LIMIT ?";
            $params[] = $limit; 
            if ($offset !== null) {
                $sql .= " OFFSET ?";
                $params[] = $offset;
            }
        } 

        $stmt = $this->connection->prepare($sql);
        if (count($params) > 0) {
            $stmt->bind_param(str_repeat("i", count($params)), ...$params);
        }

        $stmt->execute();
        $stmt->bind_result($id, $brand, $model, $release_year, $screen_size, $battery_capacity, $ram, $storage, $camera, $price, $os, $ratings, $image_url);

        $phones = [];
        while ($stmt->fetch()) {
            $screen_size = (float) $screen_size;
            $price = (int) $price;

            $phones[] = new Phone(
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
        $stmt->close();

        return $phones;
    }

    public function getAllPhonesBasicInfo(?int $limit = null, ?int $offset = null): array {
        $sql = "SELECT id, brand, model FROM phones";
        $params = [];
        if ($limit !== null) {
            $sql .= " LIMIT ?";
            $params[] = $limit; 
            if ($offset !== null) {
                $sql .= " OFFSET ?";
                $params[] = $offset;
            }
        } 

        $stmt = $this->connection->prepare($sql);
        if (count($params) > 0) {
            $stmt->bind_param(str_repeat("i", count($params)), ...$params);
        }

        $stmt->execute();
        $stmt->bind_result($id, $brand, $model);

        $phones = [];
        while ($stmt->fetch()) {
            $phones[] = new PhoneBasicInfo(
                $id,
                $brand,
                $model
            );
        }
        $stmt->close();

        return $phones;
    }
}
?>
