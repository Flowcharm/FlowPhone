<?php
require_once __DIR__."/../../models/db_manager.php";
require_once __DIR__."/../../repositories/phone_repository.php";
require_once __DIR__."/../../controllers/phone_controller.php";
require_once __DIR__."/../../helpers/get_env.php";


$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"));

$phone_repository = new PhoneRepository($db);

$phone_controller = new PhoneController($phone_repository);

header('Content-Type: application/json');
try {
    $method = $_SERVER['REQUEST_METHOD']; // TODO: Use the request method to determine the action
    
    $params = $_GET;
    $response = $phone_controller->handle_request($params);

    echo json_encode(["data" => $response ?? [], "error" => null]);
} catch (Exception $e) {
    $code = 500;
    if ($e instanceof InvalidArgumentException) {
        $code = 400;
    } else {
        $code = 500;
    }

    http_response_code($code);
    echo json_encode(["error" => $e->getMessage()]);
}

?>
