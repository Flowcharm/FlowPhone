<?php
declare(strict_types=1);

require_once __DIR__.'/../interfaces/db_manager_interface.php';
require_once __DIR__.'/../interfaces/phone_interface.php';

require_once __DIR__.'/../models/phone.php';

class PhoneRepository implements IPhoneRepository {
    public function __construct(
        private IDb_Manager $db_manager
    )
    { }

    public function get_by_id(int $searchId): ?Phone {
        $connection = $this->db_manager->connect();

        $sql = "SELECT id, brand, model, release_year, screen_size, battery_capacity, ram, storage, camera_mp, price, os, ratings, image_url FROM phones WHERE id = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("i", $searchId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $fields = $result->fetch_assoc();

        if ($result->num_rows === 0) {
            return null;
        }

        return new Phone(
            $fields["id"],
            $fields["brand"],
            $fields["model"],
            $fields["release_year"],
            (float) $fields["screen_size"],
            $fields["battery_capacity"],
            $fields["ram"],
            $fields["storage"],
            $fields["camera_mp"],
            (float) $fields["price"],
            $fields["os"],
            $fields["ratings"],
            $fields["image_url"]
        );
    }

    public function get_all(?int $limit = null, ?int $offset = null, ?string $brand = null, ?int $min_price = null, ?int $max_price = null, ?string $search = null): array {
        $connection = $this->db_manager->connect();

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

        $stmt = $connection->prepare($sql);
        if (count($sqlParams) > 0) {
            $stmt->bind_param($types, ...$sqlParams);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $phones = [];
        while ($fields = $result->fetch_assoc()) {
            $phones[] = new Phone(
                $fields["id"],
                $fields["brand"],
                $fields["model"],
                $fields["release_year"],
                (float) $fields["screen_size"],
                $fields["battery_capacity"],
                $fields["ram"],
                $fields["storage"],
                $fields["camera_mp"],
                (float) $fields["price"],
                $fields["os"],
                $fields["ratings"],
                $fields["image_url"]
            );
        }

        return $phones;
    }

    public function get_all_basic_info(?int $limit = null, ?int $offset = null): array {
        $connection = $this->db_manager->connect();

        $sql = "SELECT id, brand, model, image_url FROM phones";
        $sqlParams = [];
        $types = "";

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
        
        $stmt = $connection->prepare($sql);
        if (count($sqlParams) > 0) {
            $stmt->bind_param($types, ...$sqlParams);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $phones = [];
        while ($fields = $result->fetch_assoc()) {
            $phones[] = new PhoneBasicInfo(
                $fields["id"],
                $fields["brand"],
                $fields["model"],
                $fields["image_url"]
            );
        }

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

        $connection = $this->db_manager->connect();

        $sql = "SELECT id, brand, model, release_year, screen_size, battery_capacity, ram, storage, camera_mp, price, os, ratings, image_url FROM phones WHERE id <> ? AND (brand = ? OR model = ? OR ABS(price - ?) <= 100) LIMIT ?";

        $stmt = $connection->prepare($sql);

        $id = $phone->get_id();
        $brand = $phone->get_brand();
        $model = $phone->get_model();
        $price = $phone->get_price_eur();

        $types = "isssi";
        $stmt->bind_param($types, $id, $brand, $model, $price, $limit);
    
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $phones = [];

        while ($fields = $result->fetch_assoc()) {
            $phones[] = new Phone(
                $fields["id"],
                $fields["brand"],
                $fields["model"],
                $fields["release_year"],
                (float) $fields["screen_size"],
                $fields["battery_capacity"],
                $fields["ram"],
                $fields["storage"],
                $fields["camera_mp"],
                (float) $fields["price"],
                $fields["os"],
                $fields["ratings"],
                $fields["image_url"]
            );
        }

        return $phones;
    }


}
?>
