<?php
declare(strict_types=1);

require_once __DIR__."/../repositories/phone_repository.php";

class PhoneController {
    public function __construct(private PhoneRepository $phone_repository) { }

    public function handle_get_request(array $params): array | Phone {
        $phones = [];

        if (isset($params["basic"]) && $params["basic"] !== "false") {
            $phones = $this->get_all_basic_info($params);
        } else if (isset($params["similar"]) && $params["similar"] !== "false") {
            if (!isset($params["id"])) {
                $phones = $this->get_similar((int)$params["similar"], (int)($params["limit"] ?? 3));
            } else {
                $phones = $this->get_similar((int)$params["id"], (int)($params["limit"] ?? 3));
            }
        } else if (isset($params["id"])) {
            $phones[] = $this->get_by_id((int)$params["id"]);
        } else {
            $phones = $this->get_all($params);
        }         
        
        $response = [];

        if (empty($phones) || count($phones) === 0 || $phones[0] === null) {
            return $response;
        }

        foreach ($phones as $phone) {
            $response[] = $phone->toArray();
        }

        if (count($response) === 1 && isset($params["id"])) {
            return $response[0];
        }
        return $response;
    }

    public function handle_post_request(array $params): Phone {
        // TODO: Validate permissions
        
        $phone = new Phone(
            id: null,
            brand: $params["brand"],
            model: $params["model"],
            release_year: (int)$params["release_year"],
            screen_size_inch: (float)$params["screen_size_inch"],
            battery_capacity_mah: (int)$params["battery_capacity_mah"],
            ram_gb: (int)$params["ram_gb"],
            storage_gb: (int)$params["storage_gb"],
            camera_mp: (int)$params["camera_mp"],
            price_eur: (float)$params["price_eur"],
            os: $params["os"],
            ratings: (int)$params["ratings"],
            image_url: $params["image_url"]
        );

        $phone = $this->phone_repository->insert($phone);
        if (!$phone->get_id()) {
            throw new Exception("Phone not inserted");
        }

        return $phone;
    }

    public function handle_put_request(array $params): Phone {
        // TODO: Validate permissions

        if (!isset($params["id"])) {
            throw new InvalidArgumentException("Phone id is required");
        }

        $phone = $this->phone_repository->get_by_id((int)$params["id"]);
        if (!$phone) {
            throw new InvalidArgumentException("Phone not found");
        }

        $phone = new Phone(
            id: $phone->get_id(),
            brand: $params["brand"] ?? $phone->get_brand(),
            model: $params["model"] ?? $phone->get_model(),
            release_year: (int)($params["release_year"] ?? $phone->get_release_year()),
            screen_size_inch: (float)($params["screen_size_inch"] ?? $phone->get_screen_size_inch()),
            battery_capacity_mah: (int)($params["battery_capacity_mah"] ?? $phone->get_battery_capacity_mah()),
            ram_gb: (int)($params["ram_gb"] ?? $phone->get_ram_gb()),
            storage_gb: (int)($params["storage_gb"] ?? $phone->get_storage_gb()),
            camera_mp: (int)($params["camera_mp"] ?? $phone->get_camera_mp()),
            price_eur: (float)($params["price_eur"] ?? $phone->get_price_eur()),
            os: $params["os"] ?? $phone->get_os(),
            ratings: (int)($params["ratings"] ?? $phone->get_ratings()),
            image_url: $params["image_url"] ?? $phone->get_image_url()
        );

        $phone = $this->phone_repository->update($phone);
        if (!$phone) {
            throw new Exception("Phone not updated");
        }

        return $phone;
    }

    public function handle_delete_request(array $params): Phone {
        // TODO: Validate permissions

        if (!isset($params["id"])) {
            throw new InvalidArgumentException("Phone id is required");
        }

        $phone = $this->phone_repository->delete((int)$params["id"]);
        if (!$phone) {
            throw new Exception("Phone not deleted");
        }

        return $phone;
    }

    public function get_by_id(int $id): Phone {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("Phone id must be a number");
        }

        if (!$id) {
            throw new InvalidArgumentException("Phone id cannot be empty");
        }

        $phone = $this->phone_repository->get_by_id($id);
        if (!$phone) {
            throw new InvalidArgumentException("Phone not found");
        }

        return $phone;
    }

    public function get_all(array $params): array {
        [$limit, $offset, $brand, $min_price, $max_price, $search, $skip_phones] = $this->validate_search_params($params);
        return $this->phone_repository->get_all($limit, $offset, $brand, $min_price, $max_price, $search, $skip_phones);
    }

    public function get_all_basic_info(array $params): array {
        [$limit, $offset] = $this->validate_limit_offset($params);
        return $this->phone_repository->get_all_basic_info($limit, $offset);
    }

    public function get_similar(int $id, int $limit): array {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("Phone id must be a number");
        }
        if (isset($limit) && !is_numeric($limit)) {
            throw new InvalidArgumentException("Limit must be a number");
        }
        $phones = $this->phone_repository->get_similar((int)$id, (int)$limit);
        return $phones;
    }

    private function validate_search_params(array $params): array {
        [$limit, $offset] = $this->validate_limit_offset($params);
        $brand = null;
        $min_price = null;
        $max_price = null;
        $search = null;
        $skip_phones = null;

        if (isset($params["brand"])) {
            $brand = $params["brand"];
        }

        if (isset($params["min_price"])) {
            $min_price = (int)$params["min_price"];
            if ($min_price < 0) {
                throw new InvalidArgumentException("Min price must be a positive number");
            }
        }

        if (isset($params["max_price"])) {
            $max_price = (int)$params["max_price"];
        }

        if ($max_price !== null) {
            if ($max_price < 0) {
                throw new InvalidArgumentException("Max price must be a positive number");
            }
            if ($min_price && $max_price < $min_price) {
                throw new InvalidArgumentException("Max price must be greater than min price");
            }
        }

        if (isset($params["search"])) {
            $search = $params["search"];
        }

        if (isset($params["skip_phones"])) {
            $skip_phones = explode(",", $params["skip_phones"]); // array of phone ids: [1, 2, 3]
        }

        return [$limit, $offset, $brand, $min_price, $max_price, $search, $skip_phones];
    }

    private function validate_limit_offset(array $params): array {
        $limit = null;
        if (isset($params["limit"])) {
            $limit = (int)$params["limit"];
            if ($limit <= 0) {
                throw new InvalidArgumentException("Limit must be a positive number");
            }
        }

        $offset = null;
        if (isset($params["offset"])) {
            $offset = (int)$params["offset"];
            if ($offset < 0) {
                throw new InvalidArgumentException("Offset must be a positive number");
            }
            if (!$limit) {
                throw new InvalidArgumentException("Offset cannot be used without limit");
            }
        }

        return [$limit, $offset];
    }
}
?>
