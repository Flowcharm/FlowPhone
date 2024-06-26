<?php
require_once __DIR__ . "/../interfaces/db_manager_interface.php";
require_once __DIR__ . "/../helpers/bcrypt.php";
require_once __DIR__ . "/../models/user.php";

class User_Repository
{
    private IDb_Manager $db_manager;

    function __construct(IDb_Manager $db_manager)
    {
        $this->db_manager = $db_manager;
    }

    function get_by_googleId($googleId)
    {
        $connection = $this->db_manager->connect();
        $stmt = $connection->prepare("SELECT * FROM users WHERE googleId = ?");
        $stmt->bind_param("i", $googleId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows === 0) {
            return null;
        }

        $fields = $result->fetch_assoc();

        $user = new User($fields["name"], $fields["email"], $fields["password"]);

        $user->set_id($fields["id"]);
        $user->set_isVerified($fields["isVerified"]);
        $user->set_isGoogleAccount($fields["isGoogleAccount"]);
        $user->set_googleId($fields["googleId"]);

        return $user;
    }

    function get_by_id($id)
    {
        $connection = $this->db_manager->connect();
        $stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $fields = $result->fetch_assoc();
        if ($result->num_rows === 0) {
            return null;
        }

        $user = new User($fields["name"], $fields["email"], $fields["password"]);

        $user->set_id($fields["id"]);
        $user->set_isVerified($fields["isVerified"]);
        $user->set_isGoogleAccount($fields["isGoogleAccount"]);
        $user->set_googleId($fields["googleId"]);

        return $user;
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

        $user = new User($fields["name"], $fields["email"], $fields["password"]);

        $user->set_id($fields["id"]);
        $user->set_isVerified($fields["isVerified"]);
        $user->set_isGoogleAccount($fields["isGoogleAccount"]);
        $user->set_googleId($fields["googleId"]);

        return $user;
    }

    function create($entity)
    {
        $connection = $this->db_manager->connect();

        $stmt = $connection->prepare("INSERT INTO users (name, email, password, isVerified, isGoogleAccount, googleId) VALUES (?, ?, ?, ?, ?, ?)");

        if (!$entity->get_isGoogleAccount()) {
            $hashedPassword = hashPassword($entity->get_password());
        }

        $stmt->bind_param("sssiis", $entity->get_name(), $entity->get_email(), $hashedPassword, $entity->get_isVerified(), $entity->get_isGoogleAccount(), $entity->get_googleId());

        $stmt->execute();

        $stmt->close();

        // Get the last inserted ID
        $id = mysqli_insert_id($connection);

        // Set the ID of the entity
        $entity->set_id($id);

        $entity->set_password($hashedPassword);
    }

    function update($entity, $fields)
    {
        $id = $entity->get_id();
        $name = $fields["name"] ?? $entity->get_name();
        $email = $fields["email"] ?? $entity->get_email();
        $password = $fields["password"];
        $isVerified = $fields["isVerified"] ?? $entity->get_isVerified();
        $isGoogleAccount = $fields["isGoogleAccount"] ?? $entity->get_isGoogleAccount();

        if (!empty($password)) {
            $password = hashPassword($password);
        }

        $connection = $this->db_manager->connect();


        if (!empty($password)) {
            $stmt = $connection->prepare("UPDATE users SET name = ?, email = ?, password = ?, isVerified = ?, isGoogleAccount = ? WHERE id = ?");
            $stmt->bind_param("sssiii", $name, $email, $password, $isVerified, $isGoogleAccount, $id);
        } else {
            $stmt = $connection->prepare("UPDATE users SET name = ?, email = ?, isVerified = ?, isGoogleAccount = ? WHERE id = ?");
            $stmt->bind_param("sssii", $name, $email, $isVerified, $isGoogleAccount, $id);
        }

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