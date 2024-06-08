<?php
require_once __DIR__ . "/../interfaces/db_manager_interface.php";
require_once __DIR__ . "/../interfaces/repository_interface.php";
require_once __DIR__ . "/../models/user.php";

class User_Repository
{
    private IDb_Manager $db_manager;

    function __construct(IDb_Manager $db_manager)
    {
        $this->db_manager = $db_manager;
    }

    function get_all()
    {
        $connection = $this->db_manager->connect();
        $result = $connection->query("SELECT * FROM users");

        print_r($result);
    }

    function get_by_id($id)
    {
        $connection = $this->db_manager->connect();
        $stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        print_r($result);
    }

    function get_by_email($email)
    {
        $connection = $this->db_manager->connect();
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $fields = $result->fetch_assoc();

        if ($result->num_rows === 0) {
            return null;
        }

        return new User($fields["name"], $fields["email"], $fields["password"]);
    }

    function create($entity)
    {
        $connection = $this->db_manager->connect();

        $stmt = $connection->prepare("INSERT INTO users (name, email, password, isVerified, isGoogleAccount) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("sssii", $entity->get_name(), $entity->get_email(), $entity->get_password(), $entity->get_isVerified(), $entity->get_isGoogleAccount());

        $stmt->execute();

        $stmt->close();
    }

    function update($entity)
    {
        $connection = $this->db_manager->connect();

        $hashed_password = hashPassword($entity->get_password());

        $stmt = $connection->prepare("UPDATE users SET name = ?, email = ?, password = ?, isVerified = ?, isGoogleAccount = ? WHERE id = ?");

        $stmt->bind_param("sssii", $entity->get_name(), $entity->get_email(), $hashed_password, $entity->get_isVerified(), $entity->get_isGoogleAccount());

        $stmt->execute();

        $stmt->close();
    }

    function delete($id)
    {
        $connection = $this->db_manager->connect();

        $stmt = $connection->prepare("DELETE FROM users WHERE id = ?");

        $stmt->bind_param("s", $id);

        $stmt->execute();

        $stmt->close();
    }
}