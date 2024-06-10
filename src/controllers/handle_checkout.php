<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../models/payments_manager.php";
require_once __DIR__ . "/../repositories/cart_repository.php";
require_once __DIR__ . "/../repositories/phone_repository.php";

function handle_checkout()
{
    global $user;

    $_POST = json_decode(file_get_contents('php://input'), true);

    $items = $_POST['items'];

    if (!$items || count($items) === 0) {
        http_response_code(400);
        echo json_encode([
            "error" => "Missing field"
        ]);
        exit;
    }

    $payments_manager = new Payments_manager();

    $phones = array();
    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
    $phone_repo = new PhoneRepository($db);
    $cart_repo = new Cart_Repository($db);

    foreach ($items as $item) {
        $phone_id = $item['id'];
        $phone = $phone_repo->get_by_id($phone_id);

        // Remove item from cart
        $user->remove_from_cart($cart_repo, $phone_id);

        if ($phone) {
            array_push($phones, ["phone" => $phone, "quantity" => $item['quantity']]);
        }
    }

    $user->checkout($payments_manager, $phones);
}