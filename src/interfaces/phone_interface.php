<?php
declare(strict_types=1);

interface IPhoneRepository {
    
    public function getPhoneById(int $id): ?Phone;

    /**
     * @return Phone[]
     */
    public function getAllPhones(): array;
}
?>