<?php
require_once __DIR__ . "/../../controllers/handle_update_account.php";
require_once __DIR__ . '/../../constants/http_verbs.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case $http_PATCH:
        handle_update_account();
        break;
}