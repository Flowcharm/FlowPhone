<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../models/mail_manager.php";
require_once __DIR__ . "/../repositories/user_repository.php";
require_once __DIR__ . "/../helpers/env.php";
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

function handle_forgot_password()
{
    $_POST = json_decode(file_get_contents('php://input'), true);
    $email = $_POST['email'];

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
    $mail = new Mail_Manager(env("SMTP_HOST"), true, env("SMTP_USERNAME"), env("SMTP_PASSWORD"), PHPMailer::ENCRYPTION_SMTPS, env("SMTP_PORT"));

    $user_repo = new User_Repository($db);
    $user = $user_repo->get_by_email($email);

    if (!$user) {
        $resp = array(
            "error" => "Email is incorrect"
        );

        echo json_encode($resp);
        die();
    }

    $user->send_forgot_password_email($mail);

    $resp = array(
        "error" => null
    );

    echo json_encode($resp);
}