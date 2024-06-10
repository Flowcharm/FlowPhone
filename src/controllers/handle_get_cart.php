<?php
require_once __DIR__ . "/../models/db_manager.php";
require_once __DIR__ . "/../repositories/cart_repository.php";

function handle_get_cart()
{
    global $user;

    $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
    $cart_repo = new Cart_Repository($db);
    $cart = $cart_repo->get_by_user_id($user->get_id());

    echo json_encode($cart);
}