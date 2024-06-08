<?php
require_once __DIR__ . "/../interfaces/mail_manager_interface.php";
require_once __DIR__ . "/../helpers/jwt.php";
require_once __DIR__ . "/../helpers/get_env.php";
require_once __DIR__ . "/../helpers/bcrypt.php";

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $isVerified = false;
    private $isGoogleAccount = false;

    function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;

        $hashed_password = hashPassword($password);
        $this->password = $hashed_password;
    }

    function send_verify_email(IMail_Manager $mailManager)
    {
        $jwt = generateJwt($this->id);

        $baseUrl = getEnv("BASE_URL");
        $url = "$baseUrl/src/app/verify.php?token=$jwt";

        $mailManager->send($this->email, "Verify your email", "Please verify your email by clicking the link below: <a href=\"$url\">$url</a>");
    }

    function send_forgot_password_email(IMail_Manager $mailManager)
    {
        $jwt = generateJwt($this->id);

        $baseUrl = getEnv("BASE_URL");
        $url = "$baseUrl/src/app/reset-password.php?token=$jwt";

        $mailManager->send($this->email, "Reset your password", "Please reset your password by clicking the link below: <a href=\"$url\">$url</a>");
    }

    function verify()
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
        $hashed_password = hashPassword($password);
        $this->password = $hashed_password;
    }

    function get_id()
    {
        return $this->id;
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