<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../repositories/review_repository.php";

function handle_get_reviews()
{
    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
    $reviewRepository = new Review_Repository($db);

    $phone_id = $_GET['phone_id'];

    if (!$phone_id) {
        http_response_code(400);
        echo json_encode([
            "error" => "phone_id is required"
        ]);
        die();
    }

    $reviews = $reviewRepository->get_all_by_phone_id($phone_id);
    echo json_encode($reviews);
}