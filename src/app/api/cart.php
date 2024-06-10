<?php
require_once __DIR__ . "/../../helpers/protect_api_route.php";
require_once __DIR__ . "/../../controllers/handle_get_cart.php";
require_once __DIR__ . "/../../controllers/handle_add_to_cart.php";
require_once __DIR__ . "/../../controllers/handle_delete_from_cart.php";
require_once __DIR__ . '/../../constants/http_verbs.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case $http_PUT:
        handle_add_to_cart();
        break;
    case $http_GET:
        handle_get_cart();
        break;
    case $http_DELETE:
        handle_delete_from_cart();
        break;
}