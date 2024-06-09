<?php
session_start();

require_once __DIR__ . "/env.php";
require_once __DIR__ . "/../repositories/user_repository.php";
require_once __DIR__ . "/../models/db_manager.php";

// if (!isset($_SESSION['user_id'])) {
//     http_response_code(403);
//     die;
// }

$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
$userRepository = new User_Repository($db);

$user = $userRepository->get_by_id(7);

if (!$user || !$user->get_isVerified()) {
    http_response_code(403);
    die;
}