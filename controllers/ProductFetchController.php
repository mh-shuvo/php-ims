<?php
require(__DIR__."/../database/MySqlConnection.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class ProductFetchController extends MySqlConnection
{
    public $connection = null;
    public function __construct(){
        $this->connection = $this->connect();
    }
    public function getAllProduct()
    {
        $query = "SELECT products.*,`user`.name AS 'added_by' FROM products JOIN `user` ON `user`.id = products.created_by;";
        $result = $this->connection->query($query);
        return $result->fetch_all(1);
    }

    public function getSingleProductById($id)
    {
        $query = "SELECT * FROM products WHERE id = $id";
        $result = $this->connection->query($query);
        return $result;
    }
}