<?php
require_once __DIR__ . "/../interfaces/mail_manager_interface.php";
require_once __DIR__ . "/../helpers/jwt.php";
require_once __DIR__ . "/../helpers/env.php";

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $google_id;
    private $isVerified = false;
    private $isGoogleAccount = false;

    function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    function send_verify_email(IMail_Manager $mailManager)
    {
        $payload = array("id" => $this->id);
        $jwt = generateJwt($payload);

        $baseUrl = env("BASE_URL");
        $url = "$baseUrl/src/app/api/verify.php?token=$jwt";

        $mailManager->sendMail($this->email, "Verify your email", "Please verify your email by clicking the link below: <a href=\"$url\">$url</a>");
    }

    function send_forgot_password_email(IMail_Manager $mailManager)
    {
        $payload = array("id" => $this->id);

        $jwt = generateJwt($payload);

        $baseUrl = env("BASE_URL");
        $url = "$baseUrl/src/app/reset-password.php?token=$jwt";

        $mailManager->sendMail($this->email, "Reset your password", "Please reset your password by clicking the link below: <a href=\"$url\">$url</a>");
    }

    function verify_email()
    {
        $this->isVerified = true;
    }

    function setGoogleAccount()
    {
        $this->isGoogleAccount = true;
    }

    function set_id($id)
    {
        $this->id = $id;
    }

    function set_password($password)
    {
        $this->password = $password;
    }

    function set_isVerified($isVerified)
    {
        $this->isVerified = $isVerified;
    }

    function set_isGoogleAccount($isGoogleAccount)
    {
        $this->isGoogleAccount = $isGoogleAccount;
    }

    function get_id()
    {
        return $this->id;
    }

    function get_googleId()
    {
        return $this->google_id;
    }

    function set_googleId($google_id)
    {
        $this->google_id = $google_id;
    }

    function get_name()
    {
        return $this->name;
    }

    function get_email()
    {
        return $this->email;
    }

    function get_password()
    {
        return $this->password;
    }

    function get_isVerified()
    {
        return $this->isVerified;
    }

    function get_isGoogleAccount()
    {
        return $this->isGoogleAccount;
    }
}