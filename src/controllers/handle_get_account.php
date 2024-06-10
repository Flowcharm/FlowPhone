<?php
require_once __DIR__ . "/../helpers/protect_api_route.php";

function handle_get_account(){
    global $user;

    echo json_encode($user);
}