<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../repositories/user_repository.php";
require_once __DIR__ . "/../helpers/env.php";
require_once __DIR__ . "/../helpers/bcrypt.php";

function handle_update_account()
{
    global $user;

    $_POST = json_decode(file_get_contents('php://input'), true);

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));

    $userRepository = new User_Repository($db);

    $newEmail = $_POST['email'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $newName = $_POST['name'];

    $user->set_email($newEmail ?? $user->get_email());
    $user->set_name($newName ?? $user->get_name());

    if (!empty($newPassword)) {
        $isCurrentPasswordCorrect = verifyPassword($currentPassword, $user->get_password());
    }

    if (!$isCurrentPasswordCorrect && !empty($newPassword)) {
        http_response_code(401);
        echo json_encode(["error" => "Current password is incorrect"]);
        die;
    } else if ($isCurrentPasswordCorrect && !empty($newPassword)) {
        $userRepository->update(
            $user,
            array(
                "password" => $newPassword,
                "email" => $newEmail,
                "name" => $newName ?? $user->get_name()
            )
        );
        echo json_encode(["error" => null]);
        die;
    } else {
        $userRepository->update(
            $user,
            array(
                "email" => $newEmail,
                "name" => $newName
            )
        );
        echo json_encode(["error" => null]);
        die;
    }
}