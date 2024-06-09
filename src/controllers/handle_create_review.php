<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../models/review.php";
require_once __DIR__ . "/../repositories/review_repository.php";
require_once __DIR__ . "/../helpers/protect_api_route.php";

function handle_create_review()
{
    global $user;

    $_POST = json_decode(file_get_contents('php://input'), true);

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
    $reviewRepository = new Review_Repository($db);

    $phone_id = $_POST["phone_id"];
    $review = $_POST["review"];
    $rating = $_POST["rating"];

    if (!$phone_id || !$review || !$rating) {
        http_response_code(400);
        echo json_encode(["error" => "Missing required fields"]);
        return;
    }

    $review = new Review($phone_id, $user->get_id(), $review, $rating);
    $reviewRepository->create($review);
}