<?php
session_start();

require_once __DIR__ . '/../../helpers/env.php';
require_once __DIR__ . '/../../repositories/user_repository.php';
require_once __DIR__ . '/../../models/db_manager.php';
require_once __DIR__ . '/../../models/user.php';
require __DIR__ . '/../../../vendor/autoload.php';

$client = new Google\Client();
$client->setClientId(env("GOOGLE_OAUTH_CLIENT_ID"));
$client->setClientSecret(env("GOOGLE_OAUTH_CLIENT_SECRET"));
$client->setRedirectUri(env("GOOGLE_OAUTH_REDIRECT_URI"));
$client->addScope("https://www.googleapis.com/auth/userinfo.email");
$client->addScope("https://www.googleapis.com/auth/userinfo.profile");

if (isset($_GET['code'])) {
    $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($accessToken);

    if (isset($accessToken['access_token'])) {
        $db = new Db_Manager(env("DB_HOST"), env("DB_USER"), env("DB_PASSWORD"), env("DB_NAME"), env("DB_PORT"));
        $userRepository = new User_Repository($db);

        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $name = $google_account_info->name;
        $email = $google_account_info->email;
        $id = $google_account_info->id;

        $user = $userRepository->get_by_googleId($email);

        if(!$user){
            $newUser = new User($name, $email, null);
            $newUser->set_GoogleId($id);
            $newUser->verify_email();

            $userRepository->create($newUser);

            $_SESSION["user_id"] = $newUser->get_id();
        }else{
            $_SESSION["user_id"] = $user->get_id();
        }

        header('Location: ../index.php');
    } else {
        exit('Invalid access token! Please try again later!');
    }
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
}