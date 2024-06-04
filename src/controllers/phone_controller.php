<?php
declare(strict_types=1);

require_once "../repositories/phone_repository.php";

class PhoneController {
    public function __construct(
        private PhoneRepository $phoneRepository
    ) { }

    public function handleRequest(array $params) {
        if (isset($params["basic"]) && $params["basic"] !== "false") {
            return $this->getAllPhonesBasicInfo($params);
        } else if (isset($params["id"])) {
            return $this->getPhoneById($params["id"]);
        }         
        return $this->getAllPhones($params);
    }

    private function getPhoneById($id) {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("Phone id must be a number");
        }
        $phone = $this->phoneRepository->getPhoneById((int)$id);
        return $phone ? $phone->toArray() : null;
    }

    private function getAllPhones($params) {
        list($limit, $offset) = $this->validateLimitAndOffset($params);

        $phones = $this->phoneRepository->getAllPhones($limit, $offset);
        $phonesArray = [];
        foreach ($phones as $phone) {
            $phonesArray[] = $phone->toArray();
        }
        return $phonesArray;
    }

    private function getAllPhonesBasicInfo($params) {
        list($limit, $offset) = $this->validateLimitAndOffset($params);

        $phones = $this->phoneRepository->getAllPhonesBasicInfo($limit, $offset);
        $phonesArray = [];
        foreach ($phones as $phone) {
            $phonesArray[] = $phone->toArray();
        }
        return $phonesArray;
    }
    
    private function validateLimitAndOffset(array $params): array {
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
