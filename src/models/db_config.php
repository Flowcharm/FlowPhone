<?php
class Db_Config
{
    protected $host;
    protected $user;
    protected $password;
    protected $dbName;

    function Dbconfig($host, $user, $password, $dbName)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
    }
}