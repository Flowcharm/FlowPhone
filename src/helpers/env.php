<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../..");
$dotenv->load();

function env($key, $default = null)
{
    return $_ENV[$key] ?? $default;
}