<?php
require_once __DIR__."/../../../models/db_manager.php";
require_once __DIR__."/../../../repositories/phone_repository.php";
require_once __DIR__."/../../../controllers/phone_controller.php";
require_once __DIR__."/../../../helpers/env.php";
require_once __DIR__."/../../../helpers/image_upload.php";

$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
$phone_repository = new PhoneRepository($db);
$phone_controller = new PhoneController($phone_repository);

header('Content-Type: application/json');
try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method !== 'POST') {
        throw new Exception("Method not allowed", 405);
    }

    $body = $_POST;
    if (isset($_FILES["image"])) {
        $image_file = $_FILES["image"];
        $brand = strtolower(str_replace(" ", "", $body["brand"]));
        $model = strtolower(str_replace(" ", "", $body["model"]));
        $upload_dir = $body["image_url"] ?? "/images/phones/{$brand}_{$model}.webp";
        $body["image_url"] = upload_converted_image($image_file, $upload_dir);
    } else {
        // throw new InvalidArgumentException("Image is required", 400); // Image must be required?
        $body["image_url"] = "/images/phones/default.webp";
    }

    $response = $phone_controller->handle_post_request($body)->toArray();
    echo json_encode(["data" => $response, "error" => null]);
} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode(["error" => $e->getMessage()]);
} catch (Exception $e) {
    http_response_code($e->getCode() > 0 ? $e->getCode() : 500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
