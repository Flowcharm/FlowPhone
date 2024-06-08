<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . "/../interfaces/mail_manager_interface.php";
require_once __DIR__ . "/../helpers/env.php";

class Mail_Manager implements IMail_Manager
{
    protected $host;
    protected $smtp_auth;
    protected $username;
    protected $password;
    protected $smtp_secure;
    protected $port;

    private $client;

    function __construct($host, $smtp_auth, $username, $password, $smtp_secure, $port)
    {
        $this->host = $host;
        $this->smtp_auth = $smtp_auth;
        $this->username = $username;
        $this->password = $password;
        $this->smtp_secure = $smtp_secure;
        $this->port = $port;
    }

    function init_client()
    {
        $client = new PHPMailer(true);

        $client->isSMTP();
        $client->Host = $this->host;
        $client->SMTPAuth = $this->smtp_auth;
        $client->Port = $this->port;
        $client->Username = $this->username;
        $client->Password = $this->password;

        $this->client = $client;
    }

    function sendMail($to, $subject, $message, $isHtml = true)
    {
        // Check if the client is initialized
        // If not, initialize it
        if (!$this->client) {
            $this->init_client();
        }

        $this->client->setFrom(env("NO_REPLY_MAIL"), 'FlowPhone');
        $this->client->addAddress($to);
        $this->client->isHTML($isHtml);
        $this->client->Subject = $subject;
        $this->client->Body = $message;

        $this->client->send();
    }
}