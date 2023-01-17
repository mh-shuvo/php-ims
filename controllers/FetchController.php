<?php
require(__DIR__."/../database/MySqlConnection.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class FetchController extends MySqlConnection
{
    public $connection = null;
    public function __construct(){
        $this->connection = $this->connect();
    }
    public function getAllCustomer($search=null)
    {
        $query = "SELECT * FROM customers";
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

    public function getSingleCustomerById($id)
    {
        $query = "SELECT * FROM customers WHERE id = $id";
        $result = $this->connection->query($query);
        return $result;
    }
    public function getAllProduct()
    {
        $query = "SELECT products.*,`user`.name AS 'added_by' FROM products JOIN `user` ON `user`.id = products.created_by;";
        $result = $this->connection->query($query);
        return $result->fetch_all(1);
    }
    public function getAllUser($search=null)
    {
        $currentUser =  $_SESSION['current_user']['id'];
        $query = "SELECT * FROM user WHERE id != '$currentUser'";
        if($search != null){
            $query .=" AND name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' ";
        }
        $query .=" ORDER BY id desc";

        $result = $this->connection->query($query);
        if($result){
            return $result->fetch_all(1);
        }else{
            echo $this->connection->error;
        }
    }
    public function getSingleUserById($id)
    {
        $query = "SELECT * FROM user WHERE id = '$id'";
        $result = $this->connection->query($query);
        if($result){
            return $result->fetch_assoc();
        }else{
            echo $this->connection->error;
        }
    }
    public function getAllSupplier()
    {
        $query = "SELECT * FROM suppliers ORDER BY id desc";

        $result = $this->connection->query($query);
        if($result){
            return $result->fetch_all(1);
        }else{
            echo $this->connection->error;
        }
    }
    public function getAllPurchase()
    {
        $query = "SELECT pr.*,sp.name as supplier_name,pd.product_name FROM purchases as pr join suppliers as sp on sp.id = pr.supplier_id join products as pd on pd.id = pr.product_id ORDER BY pr.id desc";

        $result = $this->connection->query($query);
        if($result){
            return $result->fetch_all(1);
        }else{
            echo $this->connection->error;
            exit;
        }
    }
    public function getAllSales()
    {
        $query = "SELECT sl.*,cu.name AS customer_name, pd.product_name FROM sales AS sl JOIN customers AS cu ON cu.id = sl.customer_id JOIN products AS pd ON pd.id = sl.product_id ORDER BY sl.id DESC ";

        $result = $this->connection->query($query);
        if($result){
            return $result->fetch_all(1);
        }else{
            echo $this->connection->error;
            exit;
        }
    }

    public function getSingleSalesById($id)
    {
        $query = "SELECT sl.*,cu.name AS customer_name, pd.product_name,pd.selling_price as unit_price FROM sales AS sl JOIN customers AS cu ON cu.id = sl.customer_id JOIN products AS pd ON pd.id = sl.product_id WHERE sl.id='$id' ORDER BY sl.id DESC ";

        $result = $this->connection->query($query);
        if($result){
            return $result->fetch_assoc();
        }else{
            echo $this->connection->error;
            exit;
        }
    }
    public function getPendingSingleSalesById($id)
    {
        $query = "SELECT sl.*,cu.name AS customer_name, pd.product_name,pd.selling_price as unit_price FROM sales AS sl JOIN customers AS cu ON cu.id = sl.customer_id JOIN products AS pd ON pd.id = sl.product_id WHERE sl.id='$id' AND sl.status='pending' ORDER BY sl.id DESC ";

        $result = $this->connection->query($query);
        if($result){
            return $result->fetch_assoc();
        }else{
            echo $this->connection->error;
            exit;
        }
    }
    public function getSinglePurchase($id)
    {
        $query = "SELECT pr.*,sp.name as supplier_name,pd.product_name,pd.buying_price FROM purchases as pr join suppliers as sp on sp.id = pr.supplier_id join products as pd on pd.id = pr.product_id WHERE pr.id='$id' ORDER BY pr.id desc";

        $result = $this->connection->query($query);
        if($result){
            return $result->fetch_assoc();
        }else{
            echo $this->connection->error;
            exit;
        }
    }
    public function getPendingSinglePurchase($id)
    {
        $query = "SELECT pr.*,sp.name as supplier_name,pd.product_name,pd.buying_price FROM purchases as pr join suppliers as sp on sp.id = pr.supplier_id join products as pd on pd.id = pr.product_id WHERE pr.id='$id' AND pr.status='pending' ORDER BY pr.id desc";

        $result = $this->connection->query($query);
        if($result){
            return $result->fetch_assoc();
        }else{
            echo $this->connection->error;
            exit;
        }
    }

    public function dashboardData(){
        $data = [
            'today_sales' => 0,
            'today_purchase' => 0,
            'total_customer' => 0,
            'total_supplier' => 0,
            'total_product' => 0,
            'total_purchase' => 0,
            'total_pending_purchase' => 0,
            'total_completed_purchase' => 0,
            'total_sales' => 0,
            'total_pending_sales' => 0,
            'total_completed_sales' => 0,
        ];
        $today = date('Y-m-d');
        $todaySales = ($this->connection->query("SELECT SUM(total_payble_amount) AS total_amount FROM sales WHERE DATE(created_at) = '$today'"))->fetch_assoc();
        $data['today_sales'] = is_null($todaySales['total_amount']) ? 0 : $todaySales['total_amount'];

        $todayPurchase = ($this->connection->query("SELECT SUM(total_purchase) AS total_amount FROM purchases WHERE DATE(created_at) = '$today'"))->fetch_assoc();
        $data['today_purchase'] = is_null($todayPurchase['total_amount']) ? 0 : $todayPurchase['total_amount'];

        $totalCustomer = ($this->connection->query("SELECT COUNT(*) AS total_customer FROM customers"))->fetch_assoc();
        $data['total_customer']  = is_null($totalCustomer['total_customer']) ? 0 : $totalCustomer['total_customer'];

        $totalSupplier = ($this->connection->query("SELECT COUNT(*) AS total_supplier FROM suppliers"))->fetch_assoc();
        $data['total_supplier']  = is_null($totalSupplier['total_supplier']) ? 0 : $totalSupplier['total_supplier'];

        $totalProduct = ($this->connection->query("SELECT COUNT(*) AS total_product FROM products"))->fetch_assoc();
        $data['total_product']  = is_null($totalProduct['total_product']) ? 0 : $totalProduct['total_product'];

        $totalPurchase = ($this->connection->query("SELECT SUM(total_purchase) AS total_amount FROM purchases"))->fetch_assoc();
        $data['total_purchase'] = is_null($totalPurchase['total_amount']) ? 0 : $totalPurchase['total_amount'];

        $totalPendingPurchase = ($this->connection->query("SELECT SUM(total_purchase) AS total_amount FROM purchases WHERE status='pending'"))->fetch_assoc();
        $data['total_pending_purchase'] = is_null($totalPendingPurchase['total_amount']) ? 0 : $totalPendingPurchase['total_amount'];

        $totalCompletedPurchase = ($this->connection->query("SELECT SUM(total_purchase) AS total_amount FROM purchases WHERE status='completed'"))->fetch_assoc();
        $data['total_completed_purchase'] = is_null($totalCompletedPurchase['total_amount']) ? 0 : $totalCompletedPurchase['total_amount'];


        $totalSales = ($this->connection->query("SELECT SUM(total_payble_amount) AS total_amount FROM sales"))->fetch_assoc();
        $data['total_sales'] = is_null($totalSales['total_amount']) ? 0 : $totalSales['total_amount'];

        $totalPendingSales = ($this->connection->query("SELECT SUM(total_payble_amount) AS total_amount FROM sales WHERE status='pending'"))->fetch_assoc();
        $data['total_pending_sales'] = is_null($totalPendingSales['total_amount']) ? 0 : $totalPendingSales['total_amount'];

        $totalCompletedSales = ($this->connection->query("SELECT SUM(total_payble_amount) AS total_amount FROM sales WHERE status='completed'"))->fetch_assoc();
        $data['total_completed_sales'] = is_null($totalCompletedSales['total_amount']) ? 0 : $totalCompletedSales['total_amount'];

        return $data;
    }
}