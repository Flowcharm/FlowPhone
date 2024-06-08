<?php
require_once __DIR__ . "/../helpers/jwt.php";
require_once __DIR__ . "/../helpers/env.php";
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../repositories/user_repository.php";

function handle_reset_password()
{
    $_POST = json_decode(file_get_contents('php://input'), true);
    $token = $_POST['token'];
    $password = $_POST['password'];

    $decoded = verifyJwt($token);

    if (!$decoded->id) {
        http_response_code(401);
        echo json_encode(["error" => "Invalid token"]);
        die();
    }

    $id = $decoded->id;

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
    $userRepo = new User_Repository($db);
    $user = $userRepo->get_by_id($id);

    if (!$user || !$user->get_isVerified()) {
        http_response_code(401);
        echo json_encode(["error" => "User not found"]);
        die();
    }

    $userRepo->update($user, ["password" => $password]);
    http_response_code(200);
    echo json_encode(["error" => null]);
}