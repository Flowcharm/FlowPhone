<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../repositories/user_repository.php";
require_once __DIR__ . "/../helpers/get_env.php";
require_once __DIR__ . "/../helpers/bcrypt.php";

function handle_login()
{
    $_POST = json_decode(file_get_contents('php://input'), true);
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $resp = array(
            "error" => "Email or password is empty"
        );

        echo json_encode($resp);
        http_response_code(403);
        die("Username or password is not valid");
    }

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"));

    $userRepository = new User_Repository($db);

    $user = $userRepository->get_by_email($email);

    if (!$user || !$user->get_isVerified()) {
        $resp = array(
            "error" => "User not found"
        );

        echo json_encode($resp);
        http_response_code(403);
        die();
    }

    $isPasswordValid = verifyPassword($password, $user->get_password());

    if (!$isPasswordValid) {
        $resp = array(
            "error" => "Email or password is not valid"
        );

        echo json_encode($resp);
        http_response_code(403);
        die();
    }

    $resp = array(
        "error" => null
    );
    http_response_code(200);
    echo json_encode($resp);
}