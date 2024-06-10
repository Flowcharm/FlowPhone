<?php
declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

// ! Need to uncomment ;extension=gd in php.ini

function upload_converted_image(array $image, string $upload_dir): string
{
    if (strpos($upload_dir, "/images") === false) {
        throw new Exception("Upload directory must be inside /images directory");
    }

    $image_info = getimagesize($image['tmp_name']);
    if ($image_info === false) {
        throw new Exception("Invalid image file");
    }

    $source_image = match ($image_info[2]) {
        IMAGETYPE_JPEG => imagecreatefromjpeg($image['tmp_name']),
        IMAGETYPE_PNG => imagecreatefrompng($image['tmp_name']),
        IMAGETYPE_GIF => imagecreatefromgif($image['tmp_name']),
        IMAGETYPE_WEBP => imagecreatefromwebp($image['tmp_name']),
        default => throw new Exception("Unsupported image type"),
    };

    if ($source_image === false) {
        throw new Exception("Failed to create image from file");
    }

    $upload_dir = preg_replace("/\.(jpg|jpeg|png|gif)$/i", ".webp", $upload_dir);
    $result = imagewebp($source_image, __DIR__ . "/../../" . $upload_dir);
    imagedestroy($source_image);

    if ($result === false) {
        throw new Exception("Failed to save image");
    }

    return $upload_dir;
}

?>
