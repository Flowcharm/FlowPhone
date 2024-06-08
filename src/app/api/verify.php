<?php
require_once __DIR__ . "/../../helpers/jwt.php";
require_once __DIR__ . "/../../models/db_manager.php";
require_once __DIR__ . "/../../repositories/user_repository.php";

$token = $_GET["token"];

if (!$token) {
    http_response_code(400);
    echo "No token provided";
    exit;
}

$decoded = verifyJwt($token);

if (!$decoded) {
    http_response_code(401);
    echo "Invalid token";
    exit;
}

$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));

$userRepository = new User_Repository($db);

$user = $userRepository->get_by_id($decoded->id);
if (!$user) {
    http_response_code(404);
    echo "User or email is incorrect";
    exit;
}

$updateFields = array(
    "isVerified" => true
);

$userRepository->update($user, $updateFields);

echo "User verified successfully";