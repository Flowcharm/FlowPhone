<?php
declare(strict_types=1);

require_once "../repositories/phone_repository.php";

class PhoneController {
    public function __construct(
        private PhoneRepository $phoneRepository
    ) { }

    public function handleRequest(array $params): array | Phone {
        $phones = [];

        if (isset($params["basic"]) && $params["basic"] !== "false") {
            $phones = $this->getAllPhonesBasicInfo($params);
        } else if (isset($params["id"])) {
            $phones[] = $this->getPhoneById((int)$params["id"]);
        } else {
            $phones = $this->getAllPhones($params);
        }         
        
        $response = [];

        if (empty($phones)) {
            return $response;
        }

        foreach ($phones as $phone) {
            $response[] = $phone->toArray();
        }

        return count($response) === 1 ? $response[0] : $response;
    }

    public function getPhoneById(int $id) {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("Phone id must be a number");
        }
        $phone = $this->phoneRepository->getPhoneById((int)$id);
        return $phone ? $phone : null;
    }

    public function getAllPhones(array $params) {
        list($limit, $offset) = $this->validateLimitAndOffset($params);

        $phones = $this->phoneRepository->getAllPhones($limit, $offset);

        return $phones;
    }

    public function getAllPhonesBasicInfo(array $params) {
        list($limit, $offset) = $this->validateLimitAndOffset($params);

        $phones = $this->phoneRepository->getAllPhonesBasicInfo($limit, $offset);
        
        return $phones;
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
