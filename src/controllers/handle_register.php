<?php
require_once __DIR__."/../models/db_manager.php";
require_once __DIR__."/../models/mail_manager.php";
require_once __DIR__."/../models/user.php";
require_once __DIR__."/../repositories/user_repository.php";
require_once __DIR__."/../helpers/get_env.php";

function handle_register()
{
    $_POST = json_decode(file_get_contents('php://input'), true);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password) || empty($name)) {
        $resp = array(
            "error" => "Email, password or name is empty"
        );

        echo json_encode($resp);
        http_response_code(403);
        die("Invalid request");
    }

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"));
    // $mail = new Mail_Manager(env("SMTP_HOST"), env(""));

    $userRepository = new User_Repository($db);

    $user = new User($name, $email, $password);

    $userRepository->create($user);

    // $user->send_verify_email();

    $resp = array(
        "error" => null
    );

    echo json_encode($resp);
    http_response_code(200);
}