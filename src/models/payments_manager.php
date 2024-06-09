<?php
require_once __DIR__."/../interfaces/payments_manager_interface.php";
require_once __DIR__."/../helpers/env.php";

class Payments_manager implements IPayments_manager{
    private $stripe;

    function __construct(){
        $this->stripe = new \Stripe\StripeClient(env("STRIPE_PRIVATE_KEY"));
    }

    function checkout($items){
        $checkoutSession = $this->stripe->checkout->sessions->create([
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
            "mode" => "payment",
        ]);

        // Redirect to the URL returned by Stripe
        header('HTTP/1.1 303 See Other');
        header('Location: ' . $checkoutSession->url);
        exit;
    }
}