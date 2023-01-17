<?php
require(__DIR__."/../database/MySqlConnection.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class SupplierFetchController extends MySqlConnection
{
    public $connection = null;
    public function __construct(){
        $this->connection = $this->connect();
    }
    public function getAllSupplier($search=null)
    {
        $query = "SELECT * FROM suppliers";
        if($search != null){
            $query .=" WHERE name LIKE '%$search%'";
        }
        $query .=" ORDER BY id desc";

        $result = $this->connection->query($query);
        if($result){
            return $result->fetch_all(1);
        }else{
            echo $this->connection->error;
        }
    }

    public function getSingleSupplierById($id)
    {
        $query = "SELECT * FROM suppliers WHERE id = $id";
        $result = $this->connection->query($query);
        return $result;
    }
}