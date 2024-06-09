<?php
declare(strict_types=1);

require_once __DIR__.'/../models/phone.php';

interface IPhoneRepository {

    /**
     * Get phone by id, return null if not found
     * @param int $id
     * @return Phone|null
     */
    public function get_by_id(int $id): ?Phone;

    /**
     * Get all phones with optional filters, return empty array if not found
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
     * Get all phones basic info with optional limit and offset, return empty array if not found
     * @return PhoneBasicInfo[]
     */
    public function get_all_basic_info(?int $limit = null, ?int $offset = null): array;

    /**
     * Get similar phones by id with optional limit, return empty array if not found
     * @param Phone|int $phone id or Phone object
     * @param int $limit
     * @return Phone[]
     */
    public function get_similar(Phone|int $phone, int $limit): array;

    /**
     * Insert phone, return inserted phone or null if failed
     * @param Phone $phone
     * @return Phone|null
     */
    public function insert(Phone $phone): Phone|null;

    /**
     * Update phone, return updated phone or null if failed
     * @param Phone $phone
     * @return Phone|null
     */
    public function update(Phone $phone): Phone|null;

    /**
     * Delete phone by id
     * @param int $id
     * @return Phone|null 
     */
    public function delete($id): Phone|null;
}
?>
