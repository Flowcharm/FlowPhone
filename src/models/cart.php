<?php

Class Cart{
    private $id;
    private $user_id;
    private $phone_id;
    private $quantity;

    function __construct($user_id, $phone_id, $quantity){
        $this->user_id = $user_id;
        $this->phone_id = $phone_id;
        $this->quantity = $quantity;
    }

    function get_user_id(){
        return $this->user_id;
    }

    function get_quantity(){
        return $this->quantity;
    }

    function set_quantity($quantity){
        $this->quantity = $quantity;
    }
    
    function get_phone_id(){
        return $this->phone_id;
    }

    function set_id($id){
        $this->id = $id;
    }

    function get_id(){
        return $this->id;
    }
}