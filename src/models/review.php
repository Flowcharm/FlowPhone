<?php
class Review
{
    private $id;
    private $phone_id;
    private $user_id;
    private $review;
    private $rating;
    private $created_at;

    function __construct($phone_id, $user_id, $review, $rating)
    {
        $this->phone_id = $phone_id;
        $this->user_id = $user_id;
        $this->review = $review;
        $this->rating = $rating;
    }

    function to_array()
    {
        return array(
            'id' => $this->id,
            'phone_id' => $this->phone_id,
            'user_id' => $this->user_id,
            'review' => $this->review,
            'rating' => $this->rating,
            'created_at' => $this->created_at
        );
    }

    function get_id()
    {
        return $this->id;
    }

    function set_id($id)
    {
        $this->id = $id;
    }

    function get_phone_id()
    {
        return $this->phone_id;
    }

    function get_user_id()
    {
        return $this->user_id;
    }

    function get_review()
    {
        return $this->review;
    }

    function get_rating()
    {
        return $this->rating;
    }

    function set_created_at($created_at)
    {
        $this->created_at = $created_at;
    }

    function get_created_at()
    {
        return $this->created_at;
    }

}