<?php

interface IDb_Manager{
    public function connect();
    public function disconnect();
    public function get_connection();
}