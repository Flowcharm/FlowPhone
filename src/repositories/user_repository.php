<?php
require_once "../interfaces/db_manager_interface.php";
require_once "../interfaces/repository_interface.php";

class User_Repository implements IRepository{
    private IDb_Manager $db_manager;

    function __construct($db_manager) {
        $this->db_manager = $db_manager;
    }

    function get_all() {
    }

    function get_by_id($id) {}

    function insert($entity) {}

    function update($entity) {}

    function delete($id) {}
}