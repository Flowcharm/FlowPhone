<?php
require_once __DIR__ . '/../../controllers/handle_login.php';
require_once __DIR__ . '/../../constants/http_verbs.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case $http_POST:
        handle_login();
        break;
}