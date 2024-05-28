<?php
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        handle_post();
        break;
}

function handle_post()
{

}
?>