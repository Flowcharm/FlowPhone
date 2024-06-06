<?php

interface IRepository{
    public function get_all();
    public function get_by_id($id);
    public function insert($entity);
    public function update($entity);
    public function delete($id);
}