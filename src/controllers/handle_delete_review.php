<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../models/review.php";
require_once __DIR__ . "/../repositories/review_repository.php";
require_once __DIR__ . "/../helpers/protect_api_route.php";

function handle_delete_review()
{
    global $user;

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
    $reviewRepository = new Review_Repository($db);

    $review_id = $_GET['review_id'];
    $review = $reviewRepository->get_by_id($review_id);

    if (!$review) {
        http_response_code(404);
        echo json_encode(["error" => "Review not found"]);
        return;
    }

    if ($review->get_user_id() !== $user->get_id()) {
        http_response_code(403);
        echo json_encode(["error" => "You are not authorized to delete this review"]);
        return;
    }

    $reviewRepository->delete($review_id);
    http_response_code(200);
    echo json_encode(["error" => null]);
}