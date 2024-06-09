<?php
require_once __DIR__ . "/../interfaces/db_manager_interface.php";
require_once __DIR__ . "/../models/cart.php";

class Cart_Repository
{
    private $db_manager;

    function __construct(IDb_Manager $db_manager)
    {
        $this->db_manager = $db_manager;
    }

    function get_all()
    {
        $connection = $this->db_manager->connect();
        $query = "SELECT * FROM carts";
        $result = $connection->query($query);
        $carts = array();

        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $user_id = $row["user_id"];
            $phone_id = $row["phone_id"];
            $quantity = $row["quantity"];

            $cart = new Cart($user_id, $phone_id, $quantity);
            $cart->id = $id;
            array_push($carts, $cart);
        }

        return $carts;
    }

    function get_by_id($id)
    {
        $connection = $this->db_manager->connect();
        $stmt = $connection->prepare("SELECT * FROM carts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user_id = $row["user_id"];
            $phone_id = $row["phone_id"];
            $quantity = $row["quantity"];

            $cart = new Cart($user_id, $phone_id, $quantity);
            $cart->set_id($id);
            return $cart;
        }

        return null;
    }

    function get_by_user_id($user_id)
    {
        $connection = $this->db_manager->connect();
        $stmt = $connection->prepare("SELECT * FROM carts WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $carts = array();

        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $phone_id = $row["phone_id"];
            $quantity = $row["quantity"];

            array_push($carts, array(
                "id" => $id,
                "phone_id" => $phone_id,
                "quantity" => $quantity
            ));
        }

        return $carts;
    }

    function get_by_user_id_and_phone_id($user_id, $phone_id)
    {
        $connection = $this->db_manager->connect();
        $stmt = $connection->prepare("SELECT * FROM carts WHERE user_id = ? AND phone_id = ?");
        $stmt->bind_param("ii", $user_id, $phone_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $id = $row["id"];
            $quantity = $row["quantity"];

            $cart = new Cart($user_id, $phone_id, $quantity);
            $cart->set_id($id);
            return $cart;
        }

        return null;
    }

    function create($entity)
    {
        $connection = $this->db_manager->connect();
        $stmt = $connection->prepare("INSERT INTO carts (user_id, phone_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $entity->get_user_id(), $entity->get_phone_id(), $entity->get_quantity());
        $stmt->execute();
        $stmt->close();
    }

    function update($entity, $fields)
    {
        $connection = $this->db_manager->connect();

        $user_id = $fields["user_id"] ?? $entity->get_user_id();
        $phone_id = $fields["phone_id"] ?? $entity->get_phone_id();
        $quantity = $fields["quantity"] ?? $entity->get_quantity();
        
        $stmt = $connection->prepare("UPDATE carts SET user_id = ?, phone_id = ?, quantity = ? WHERE id = ?");
        $stmt->bind_param("iiii", $user_id, $phone_id, $quantity, $entity->get_id());
        
        $stmt->execute();
        $stmt->close();
    }

    function delete($id)
    {
        $connection = $this->db_manager->connect();
        $stmt = $connection->prepare("DELETE FROM carts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}