<?php
require_once __DIR__ . "/../interfaces/mail_manager_interface.php";
require_once __DIR__ . "/../interfaces/payments_manager_interface.php";
require_once __DIR__ . "/cart.php";
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

    function checkout(IPayments_manager $payments_manager, array $phones)
    {
        $items = array();

        foreach ($phones as $phone) {
            array_push(
                $items,
                array(
                    "price_data" => [
                        "currency" => "usd",
                        "product_data" => [
                            "name" => $phone->get_brand(),
                        ],
                        "unit_amount" => $phone->get_price_eur() * 100 // convert to cents
                    ],
                    "quantity" => 1
                )
            );
        }

        $payments_manager->checkout($items);
    }

    function send_verify_email(IMail_Manager $mailManager)
    {
        $payload = array("id" => $this->id);
        $jwt = generateJwt($payload);

        $baseUrl = env("BASE_URL");
        $url = "$baseUrl/src/app/api/verify.php?token=$jwt";

        $mailManager->sendMail($this->email, "Verify your email", "Please verify your email by clicking the link below: <a href=\"$url\">$url</a>");
    }

    function add_to_cart(Cart_Repository $cart_repository, $phone_id, $quantity = 1)
    {
        $product_in_cart = $cart_repository->get_by_user_id_and_phone_id($this->id, $phone_id);

        if ($product_in_cart) {
            $cart_repository->update(
                $product_in_cart,
                array(
                    "quantity" => $product_in_cart->get_quantity() + $quantity
                )
            );
        } else {
            $newCart = new Cart($this->id, $phone_id, 1);
            $cart_repository->create($newCart);
        }
    }

    function decrease_cart_item(Cart_Repository $cart_repository, $phone_id, $removeQuantity = 1)
    {
        $product_in_cart = $cart_repository->get_by_user_id_and_phone_id($this->id, $phone_id);

        if ($product_in_cart->get_quantity() <= $removeQuantity) {
            $cart_repository->delete($product_in_cart->get_id());
        } else {
            $cart_repository->update(
                $product_in_cart,
                array(
                    "quantity" => $product_in_cart->get_quantity() - $removeQuantity
                )
            );
        }
    }

    function remove_from_cart(Cart_Repository $cart_repository, $phone_id)
    {
        $product_in_cart = $cart_repository->get_by_user_id_and_phone_id($this->id, $phone_id);

        if ($product_in_cart) {
            $cart_repository->delete($product_in_cart->get_id());
        }
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

    function set_email($email)
    {
        $this->email = $email;
    }

    function set_name($name)
    {
        $this->name = $name;
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