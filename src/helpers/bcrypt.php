<?php
require __DIR__ . 'vendor/autoload.php';

use Bcrypt\Bcrypt;

function hashPassword($password): string
{
    $bcrypt = new Bcrypt();
    $hash = $bcrypt->encrypt($password);
    return $hash;
}

function verifyPassword($password, $hash): bool
{
    $bcrypt = new Bcrypt();
    return $bcrypt->verify($password, $hash);
}