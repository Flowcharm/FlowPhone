<?php
declare(strict_types=1);

class PhoneBasicInfo {
    public function __construct(
        private int $id,
        private string $brand,
        private string $model,
        private string $image_url
    )
    { }

    public function get_id(): int {
        return $this->id;
    }

    public function get_brand(): string {
        return $this->brand;
    }

    public function get_model(): string {
        return $this->model;
    }

    public function get_image_url(): string {
        return "/public/" . $this->image_url;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "brand" => $this->brand,
            "model" => $this->model,
            "image_url" => $this->image_url
        ];
    }
}

class Phone { 
    public function __construct(
        private ?int $id = null,
        private string $brand,
        private string $model,
        private int $release_year,
        private float $screen_size_inch,
        private int $battery_capacity_mah,
        private int $ram_gb,
        private int $storage_gb,
        private int $camera_mp,
        private float $price_eur,
        private string $os,
        private int $ratings,
        private ?string $image_url
    )
    { }

    public function get_id(): int {
        return $this->id;
    }

    public function get_brand(): string {
        return $this->brand;
    }

    public function get_model(): string {
        return $this->model;
    }

    public function get_screen_size_inch(): float {
        return $this->screen_size_inch;
    }

    public function get_storage_gb(): int {
        return $this->storage_gb;
    }

    public function get_price_eur(): float {
        return $this->price_eur;
    }

    public function get_os(): string {
        return $this->os;
    }

    public function get_ratings(): int {
        return $this->ratings;
    }

    public function get_image_url(): string {
        // return "/public/" . $this->image_url;
        // return "/" . $this->image_url;    
        return $this->image_url;
    }

    public function get_release_year(): int {
        return $this->release_year;
    }

    public function get_battery_capacity_mah(): int {
        return $this->battery_capacity_mah;
    }

    public function get_ram_gb(): int {
        return $this->ram_gb;
    }

    public function get_camera_mp(): int {
        return $this->camera_mp;
    }

    public function set_id(int $id): void {
        if ($this->id !== null) {
            throw new Exception("Id is already set");
        }
        $this->id = $id;
    }

    public function set_image_url(string $image_url): void {
        $this->image_url = $image_url;
    }

    public function set_brand(string $brand): void {
        $this->brand = $brand;
    }

    public function set_model(string $model): void {
        $this->model = $model;
    }

    public function set_screen_size_inch(float $screen_size_inch): void {
        $this->screen_size_inch = $screen_size_inch;
    }

    public function set_storage_gb(int $storage_gb): void {
        $this->storage_gb = $storage_gb;
    }

    public function set_price_eur(float $price_eur): void {
        $this->price_eur = $price_eur;
    }

    public function set_os(string $os): void {
        $this->os = $os;
    }

    public function set_ratings(int $ratings): void {
        $this->ratings = $ratings;
    }

    public function set_release_year(int $release_year): void {
        $this->release_year = $release_year;
    }

    public function set_battery_capacity_mah(int $battery_capacity_mah): void {
        $this->battery_capacity_mah = $battery_capacity_mah;
    }

    public function set_ram_gb(int $ram_gb): void {
        $this->ram_gb = $ram_gb;
    }

    public function set_camera_mp(int $camera_mp): void {
        $this->camera_mp = $camera_mp;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "brand" => $this->brand,
            "model" => $this->model,
            "release_year" => $this->release_year,
            "screen_size_inch" => $this->screen_size_inch,
            "battery_capacity_mah" => $this->battery_capacity_mah,
            "ram_gb" => $this->ram_gb,
            "storage_gb" => $this->storage_gb,
            "camera_mp" => $this->camera_mp,
            "price_eur" => $this->price_eur,
            "os" => $this->os,
            "ratings" => $this->ratings,
            "image_url" => $this->image_url
        ];
    }
}
