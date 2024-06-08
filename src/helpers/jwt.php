<?php

use Firebase\JWT\Key;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . "/../helpers/get_env.php";

function generateJwt($payload)
{
    $jwt = \Firebase\JWT\JWT::encode($payload, env("JWT_SECRET"), 'RS256');
    return $jwt;
}

function verifyJwt($jwt)
{
    try {
        $decoded = \Firebase\JWT\JWT::decode($jwt, new Key(env("JWT_SECRET"), 'HS256'));

        return $decoded;
    } catch (Exception $e) {
        return null;
    }
}