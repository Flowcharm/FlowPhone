<?php
session_start();

require_once __DIR__ . "/env.php";
require_once __DIR__ . "/../repositories/user_repository.php";
require_once __DIR__ . "/../models/db_manager.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
$userRepository = new User_Repository($db);

$user = $userRepository->get_by_id($_SESSION['user_id']);

if (!$user || !$user->get_isVerified()) {
    header('Location: login.php');
    exit();
}