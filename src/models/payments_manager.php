<?php
require_once __DIR__."/../interfaces/payments_manager_interface.php";
require_once __DIR__."/../helpers/env.php";

$base_url = env("BASE_URL");

class Payments_manager implements IPayments_manager{
    private $stripe;

    function __construct(){
        $this->stripe = new \Stripe\StripeClient(env("STRIPE_PRIVATE_KEY"));
    }

    function checkout($items){
        global $base_url;

        $checkoutSession = $this->stripe->checkout->sessions->create([
            'success_url' => "$base_url/src/app/",
            'cancel_url' => "$base_url/src/app/",
            "line_items" => $items,
            "mode" => "payment",
        ]);
        
        echo json_encode($checkoutSession);
    }
}