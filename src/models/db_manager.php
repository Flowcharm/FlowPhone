<?php
require_once __DIR__ . "/../interfaces/db_manager_interface.php";

class Db_Manager implements IDb_Manager
{
    protected $host;
    protected $user;
    protected $password;
    protected $dbName;
    protected $port;

    private $connection;

    function __construct($host, $user, $password, $dbName, $port)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->port = $port;
    }

    // Destructor to close the database connection when the object is destroyed
    function __destruct()
    {
        $this->disconnect();
    }

    function connect()
    {
        // Check if the connection already exists
        // If it does, return it
        if ($this->connection != null) {
            return $this->connection;
        }

        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbName, (int) $this->port);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $this->connection = $conn;

        return $conn;
    }

    function get_connection()
    {
        return $this->connection;
    }

    function disconnect()
    {
        if ($this->connection != null) {
            mysqli_close($this->connection);
        }
    }
}