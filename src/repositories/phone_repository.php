<?php
declare(strict_types=1);

require_once '../models/phone.php';
require_once '../interfaces/phone_interface.php';

class PhoneRepository implements IPhoneRepository {
    public function __construct(
        private mysqli $connection
    )
    { }

    public function get_by_id(int $searchId): ?Phone {
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

    public function get_all(?int $limit = null, ?int $offset = null, ?string $brand = null, ?int $min_price = null, ?int $max_price = null, ?string $search = null): array {
        $sql = "SELECT id, brand, model, release_year, screen_size, battery_capacity, ram, storage, camera_mp, price, os, ratings, image_url FROM phones WHERE 1=1";

        $sqlParams = [];
        $types = "";

        if ($brand !== null) {
            $sql .= " AND brand LIKE ?";
            $sqlParams[] = $brand;
            $types .= "s";
        }

        if ($min_price !== null) {
            $sql .= " AND price >= ?";
            $sqlParams[] = $min_price;
            $types .= "i";
        }

        if ($max_price !== null) {
            $sql .= " AND price <= ?";
            $sqlParams[] = $max_price;
            $types .= "i";
        }

        if ($search !== null) {
            $sql .= " AND (brand LIKE ? OR model LIKE ?)";
            $sqlParams[] = "%$search%";
            $sqlParams[] = "%$search%";
            $types .= "ss";
        }

        if ($limit !== null) {
            $sql .= " LIMIT ?";
            $sqlParams[] = $limit; 
            $types .= "i";
            if ($offset !== null) {
                $sql .= " OFFSET ?";
                $sqlParams[] = $offset;
                $types .= "i";
            }
        } 

        $stmt = $this->connection->prepare($sql);
        if (!empty($sqlParams)) {
            $stmt->bind_param($types, ...$sqlParams);
        }

        $stmt->execute();
        $stmt->bind_result($id, $brand, $model, $release_year, $screen_size, $battery_capacity, $ram, $storage, $camera, $price, $os, $ratings, $image_url);

        $phones = [];
        while ($stmt->fetch()) {
            $screen_size = (float) $screen_size;
            $price = (int) $price;

            $phones[] = 
                new Phone($id, $brand, $model, $release_year, $screen_size, $battery_capacity, $ram, $storage, $camera, $price, $os, $ratings, $image_url);
        }
        $stmt->close();

        return $phones;
    }

    public function get_all_basic_info(?int $limit = null, ?int $offset = null): array {
        $sql = "SELECT id, brand, model, image_url FROM phones";
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
        $stmt->bind_result($id, $brand, $model, $image_url);

        $phones = [];
        while ($stmt->fetch()) {
            $phones[] = new PhoneBasicInfo(
                $id,
                $brand,
                $model,
                $image_url
            );
        }
        $stmt->close();

        return $phones;
    }

    public function get_similar(Phone|int $phone, int $limit): array
    {
        if (is_int($phone)) {
            $phone = $this->get_by_id($phone);
        }

        if ($phone === null) {
            return [];
        }

        $sql = "SELECT id, brand, model, release_year, screen_size, battery_capacity, ram, storage, camera_mp, price, os, ratings, image_url FROM phones WHERE id <> ? AND (brand = ? OR model = ? OR ABS(price - ?) <= 100) LIMIT ?";

        $stmt = $this->connection->prepare($sql);

        $id = $phone->get_id();
        $brand = $phone->get_brand();
        $model = $phone->get_model();
        $price = $phone->get_price_eur();

        $stmt->bind_param("isssi", $id, $brand, $model, $price, $limit);

        $stmt->execute();
        $stmt->bind_result($id, $brand, $model, $release_year, $screen_size, $battery_capacity, $ram, $storage, $camera, $price, $os, $ratings, $image_url);
        
        $phones = [];
        while ($stmt->fetch()) {
            $screen_size = (float) $screen_size;
            $price = (int) $price;

            $phones[] = 
                new Phone($id, $brand, $model, $release_year, $screen_size, $battery_capacity, $ram, $storage, $camera, $price, $os, $ratings, $image_url);
        }

        $stmt->close();
        return $phones;
    }


}
?>
