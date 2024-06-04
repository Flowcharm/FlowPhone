<?php
declare(strict_types=1);

require_once '../models/phone.php';

interface IPhoneRepository {

    public function getPhoneById(int $id): ?Phone;

    /**
     * @return Phone[]
     */
    public function getAllPhones(?int $limit = null, ?int $offset = null): array; 

    /**
     * @return PhoneBasicInfo[]
     */
    public function getAllPhonesBasicInfo(?int $limit = null, ?int $offset = null): array;
}
?>