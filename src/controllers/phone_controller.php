<?php
declare(strict_types=1);

require_once "../repositories/phone_repository.php";

class PhoneController {
    public function __construct(
        private PhoneRepository $phoneRepository
    ) { }

    public function handle_request(array $params): array | Phone {
        $phones = [];

        if (isset($params["basic"]) && $params["basic"] !== "false") {
            $phones = $this->get_all_basic_info($params);
        } else if (isset($params["id"])) {
            if (isset($params["similar"]) && $params["similar"] !== "false") {
                $phones = $this->phoneRepository->get_similar((int)$params["id"], (int) ($params["limit"] ?? 3));
            } else {
                $phones[] = $this->get_by_id((int)$params["id"]);
            }
        } else {
            $phones = $this->get_all($params);
        }         
        
        $response = [];

        if (empty($phones) || count($phones) === 0) {
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

    public function get_by_id(int $id) {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("Phone id must be a number");
        }

        if (!$id) {
            throw new InvalidArgumentException("Phone id cannot be empty");
        }

        $phone = $this->phoneRepository->get_by_id((int)$id);
        return $phone ? $phone : null;
    }

    public function get_all(array $params) {
        list($limit, $offset, $brand, $min_price, $max_price, $search) = $this->validate_search_params($params);

        $phones = $this->phoneRepository->get_all($limit, $offset, $brand, $min_price, $max_price, $search);

        return $phones;
    }

    public function get_all_basic_info(array $params) {
        list($limit, $offset) = $this->validate_limit_offset($params);

        $phones = $this->phoneRepository->get_all_basic_info($limit, $offset);
        
        return $phones;
    }

    public function get_similar(int $id, int $limit) {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("Phone id must be a number");
        }
        if (!is_numeric($limit)) {
            throw new InvalidArgumentException("Limit must be a number");
        }
        $phones = $this->phoneRepository->get_similar((int)$id, (int)$limit);
        return $phones;
    }

    private function validate_search_params(array $params): array {
        list($limit, $offset) = $this->validate_limit_offset($params);
        $brand = null;
        $min_price = null;
        $max_price = null;
        $search = null;

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

        return [$limit, $offset, $brand, $min_price, $max_price, $search];
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
