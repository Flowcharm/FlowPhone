<?php
require_once __DIR__."/../../../models/db_manager.php";
require_once __DIR__."/../../../repositories/phone_repository.php";
require_once __DIR__."/../../../controllers/phone_controller.php";
require_once __DIR__."/../../../helpers/get_env.php";

$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"));
$phone_repository = new PhoneRepository($db);
$phone_controller = new PhoneController($phone_repository);

header('Content-Type: application/json');
try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method !== 'POST' && $method !== 'GET') {
        throw new Exception("Method not allowed", 405);
    }

    $body = $method === 'POST' ? $_POST : $_GET; 

    $response = $phone_controller->handle_delete_request($body)->toArray();

    echo json_encode(["data" => $response, "error" => null]);
} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode(["error" => $e->getMessage()]);
} catch (Exception $e) {
    http_response_code($e->getCode() > 0 ? $e->getCode() : 500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
