<?php
require_once __DIR__ . "/../interfaces/db_manager_interface.php";
require_once __DIR__ . "/../models/review.php";

class Review_Repository
{
    private IDb_Manager $db_manager;

    function __construct(IDb_Manager $db_manager)
    {
        $this->db_manager = $db_manager;
    }

    function create(Review $review)
    {
        $connection = $this->db_manager->connect();
        $query = "INSERT INTO reviews (phone_id, user_id, rating, review) VALUES (?, ?, ?, ?)";
        $statement = $connection->prepare($query);
        $statement->bind_param("iiis", $review->get_phone_id(), $review->get_user_id(), $review->get_rating(), $review->get_review());
        $statement->execute();
        $statement->close();

        // Get the last inserted ID
        $id = mysqli_insert_id($connection);

        $review->set_id($id);
    }

    function get_by_id($id)
    {
        $connection = $this->db_manager->connect();
        $query = "SELECT * FROM reviews WHERE id = ?";
        $statement = $connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $results = $statement->get_result();
        $review = $results->fetch_assoc();
        $statement->close();

        $id = $review['id'];
        $phone_id = $review['phone_id'];
        $user_id = $review['user_id'];
        $reviewText = $review['review'];
        $rating = $review['rating'];
        $created_at = $review['created_at'];

        $review = new Review($phone_id, $user_id, $rating, $reviewText);
        $review->set_id($id);
        $review->set_created_at($created_at);

        return $review;
    }

    function delete($id)
    {
        $connection = $this->db_manager->connect();
        $query = "DELETE FROM reviews WHERE id = ?";
        $statement = $connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->close();
    }

    function update(Review $review, $fields)
    {
        $phone_id = $fields["phone_id"] ?? $review->get_phone_id();
        $user_id = $fields["user_id"] ?? $review->get_user_id();
        $rating = $fields["rating"] ?? $review->get_rating();
        $reviewText = $fields["review"] ?? $review->get_review();

        $connection = $this->db_manager->connect();
        $query = "UPDATE reviews SET phone_id = ?, user_id = ?, rating = ?, review = ? WHERE id = ?";
        $statement = $connection->prepare($query);
        $statement->bind_param("iiisi", $phone_id, $user_id, $rating, $reviewText, $review->get_id());
        $statement->execute();
        $statement->close();
    }

    function get_all_by_phone_id($phone_id)
    {
        $connection = $this->db_manager->connect();
        $query = "SELECT * FROM reviews WHERE phone_id = ?";
        $statement = $connection->prepare($query);
        $statement->bind_param("i", $phone_id);
        $statement->execute();
        $result = $statement->get_result();

        $reviews = array();

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $phone_id = $row['phone_id'];
            $user_id = $row['user_id'];
            $rating = $row['rating'];
            $review = $row['review'];
            $created_at = $row['created_at'];

            $review = new Review($phone_id, $user_id, $rating, $review);
            $review->set_id($id);
            $review->set_created_at($created_at);

            array_push($reviews, $review->to_array());
        }

        $statement->close();

        return $reviews;
    }
}