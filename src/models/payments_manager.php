<?php
require_once __DIR__."/../interfaces/payments_manager_interface.php";
require_once __DIR__."/../helpers/env.php";

class Payments_manager implements IPayments_manager{
    private $stripe;

    function __construct(){
        $this->stripe = new \Stripe\StripeClient(env("STRIPE_PRIVATE_KEY"));
    }

    function pay($amount){
        $this->stripe->charges->create([
            'amount' => $amount,
            'currency' => 'usd',
            'source' => 'tok_visa',
            'description' => 'Shop FlowPhone'
        ]);

    }
}