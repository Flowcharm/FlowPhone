<?php
require_once __DIR__ . '/../../constants/http_verbs.php';
require_once __DIR__ . '/../../controllers/handle_create_review.php';
require_once __DIR__ . '/../../controllers/handle_delete_review.php';
require_once __DIR__ . '/../../controllers/handle_update_review.php';
require_once __DIR__ . '/../../controllers/handle_get_reviews.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case $http_GET:
        handle_get_reviews();
        break;
    case $http_POST:
        handle_create_review();
        break;
    case $http_PATCH:
        handle_update_review();
        break;
    case $http_DELETE:
        handle_delete_review();
        break;
}