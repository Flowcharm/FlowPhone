<?php
require_once __DIR__ . "/../helpers/protect_api_route.php";
require_once __DIR__ . "/../controllers/handle_checkout.php";
require_once __DIR__ . '/../../constants/http_verbs.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case $_POST:
        handle_checkout();
        break;
}