<?php
declare(strict_types=1);

require_once __DIR__.'/../models/phone.php';

interface IPhoneRepository {

    public function get_by_id(int $id): ?Phone;

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @param string|null $brand
     * @param int|null $min_price
     * @param int|null $max_price
     * @param string|null $search
     * @return Phone[]
     */
    public function get_all(?int $limit = null, ?int $offset = null, ?string $brand = null, ?int $min_price = null, ?int $max_price = null, ?string $search = null): array;

    /**
     * @return PhoneBasicInfo[]
     */
    public function get_all_basic_info(?int $limit = null, ?int $offset = null): array;

    /**
     * @param Phone|int $phone id or Phone object
     * @param int $limit
     * @return Phone[]
     */
    public function get_similar(Phone|int $phone, int $limit): array;

    // public function insert(Phone $phone);

    // public function update(Phone $phone);

    // public function delete($id);
}
?>