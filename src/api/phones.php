<?php
require_once "../repositories/phone_repository.php";
require_once "../controllers/phone_controller.php";

// TODO
$host = "localhost";
$port = 3360;
$user = "root";
$password = "1234";
$database = "flowphone";

$connection = new mysqli($host, $user, $password, $database, $port);

$phoneRepository = new PhoneRepository($connection);

$phoneController = new PhoneController($phoneRepository);

header('Content-Type: application/json');
try {
    $params = $_GET;
    $response = $phoneController->handle_request($params);

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


