<?php
require_once __DIR__ . '/../../controllers/handle_reset_password.php';
require_once __DIR__ . '/../../constants/http_verbs.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case $http_POST:
        handle_reset_password();
        break;
}