<?php
declare(strict_types=1);

interface IPhoneRepository {
    public function getPhoneById(int $id): ?Phone;
    // TODO
}
?>