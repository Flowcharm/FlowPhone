<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../repositories/cart_repository.php";

function handle_delete_from_cart()
{
    global $user;

    $_POST = json_decode(file_get_contents('php://input'), true);

    $phone_id = $_POST['phone_id'];
    $quantity = $_POST['quantity'] ?? 1;

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
    $cart_repo = new Cart_Repository($db);

    if(empty($phone_id)) {
        http_response_code(400);
        echo json_encode([
            "error" => "Missing required fields"
        ]);
        return;
    }

    if (!empty($quantity)) {
        $user->decrease_cart_item($cart_repo, $phone_id, (int) $quantity);
    } else {
        $user->remove_from_cart($cart_repo, $phone_id);
    }

    http_response_code(200);
    echo json_encode([
        "error" => null
    ]);

}