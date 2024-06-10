<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../repositories/cart_repository.php";

function handle_add_to_cart()
{
    global $user;

    $_POST = json_decode(file_get_contents('php://input'), true);

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
    $cart_repo = new Cart_Repository($db);

    $phone_id = (int) $_POST["phone_id"];
    $quantity = $_POST["quantity"] ?? 1;
    
    if (empty($phone_id)) {
        http_response_code(400);
        die;
    }

    $user->add_to_cart($cart_repo, $phone_id, (int) $quantity);

    echo json_encode([
        "error" => null
    ]);
    http_response_code(200);
}