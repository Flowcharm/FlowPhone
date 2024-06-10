<?php
require_once __DIR__ . "/../../controllers/handle_register.php";
require_once __DIR__ . '/../../constants/http_verbs.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case $http_POST:
        handle_register();
        break;
}