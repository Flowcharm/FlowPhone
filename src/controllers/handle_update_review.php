<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../models/review.php";
require_once __DIR__ . "/../repositories/review_repository.php";
require_once __DIR__ . "/../helpers/protect_api_route.php";

function handle_update_review()
{
    global $user;

    $_POST = json_decode(file_get_contents('php://input'), true);

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
    $reviewRepository = new Review_Repository($db);

    $review_id = $_POST['review_id'];

    if (!$review_id) {
        http_response_code(400);
        echo json_encode([
            'error' => 'review_id is required'
        ]);
    }

    $review = $reviewRepository->get_by_id($review_id);

    $reviewText = $_POST["review"];
    $rating = $_POST["rating"];

    $reviewRepository->update(
        $review,
        array(
            "review" => $reviewText,
            "rating" => $rating
        )
    );

    http_response_code(200);
    echo json_encode([
        "error" => null
    ]);
}