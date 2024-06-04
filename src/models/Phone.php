<?php
declare(strict_types=1);

class Phone {
    public function __construct(
        private int $id,
        private string $brand,
        private string $model,
        private int $release_year,
        private float $screen_size_inch,
        private int $battery_capacity_mah,
        private int $ram_gb,
        private int $storage_gb,
        private int $camera_mp,
        private int $price_eur,
        private string $os,
        private int $ratings,
        private string $image_url
    )
    { }

    public function getId(): int {
        return $this->id;
    }

    public function getBrand(): string {
        return $this->brand;
    }

    public function getModel(): string {
        return $this->model;
    }

    public function getScreenSizeInch(): float {
        return $this->screen_size_inch;
    }

    public function getStorageGb(): int {
        return $this->storage_gb;
    }

    public function getPriceEur(): int {
        return $this->price_eur;
    }

    public function getOs(): string {
        return $this->os;
    }

    public function getRatings(): int {
        return $this->ratings;
    }

    public function getImageUrl(): string {
        return $this->image_url;
    }
}
?>
