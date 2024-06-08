<?php

interface IMail_Manager{
    function sendMail($to, $subject, $message, $isHtml = true);
}