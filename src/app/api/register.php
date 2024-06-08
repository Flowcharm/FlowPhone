<?php
require_once __DIR__ . "/../../controllers/handle_register.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        handle_register();
        break;
}