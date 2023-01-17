<?php
include(__DIR__."/index.php");
class SalesController extends MySqlConnection
{
    public $connection = null;
    public function __construct(){
        $this->connection = $this->connect();
    }
    public function create()
    {
        $data = $_POST;
        $_SESSION['old_value'] = $data;
        $errors = [];
        if(empty($data['customer_id'])){
            $errors['customer_id']= 'Customer field is required';
        }
        if(empty($data['sales_date'])){
            $errors['sales_date']= 'Sales Date field is required';
        }
        if(empty($data['quantity'])){
            $errors['quantity']= 'Quantity field is required';
        }
        if(empty($data['product_id'])){
            $errors['product_id']= 'Product field is required';
        }
        if(empty($data['status'])){
            $errors['status']= 'Status field is required';
        }
        if(empty($data['payment_type'])){
            $errors['payment_type']= 'Payment Type field is required';
        }
        if(!empty($data['payment_type']) && $data['payment_type'] == 'online' && empty($data['transaction_id'])){
            $errors['transaction_id']= 'Transaction field is required';
        }

        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            $redirect = BASE_URL.'?q=sales/create';
            header("Location:$redirect");
            exit();
        }

        $customer_id = $data['customer_id'];
        $sales_date = date('Y-m-d',strtotime($data['sales_date']));
        $quantity = $data['quantity'];
        $product_id = $data['product_id'];
        $note = $data['note'];
        $status = $data['status'];
        $sales_unique_number = "SA".time();
        $payment_type = $data['payment_type'];
        $discount = empty($data['discount']) ? 0 : $data['discount'];
        $subtotal = $data['subtotal'];
        $total_payable_amount = $data['total_payable_amount'];
        $transaction_id = $data['transaction_id'];


        $getSingleProductByIdQuery = $this->connection->query("SELECT * FROM products WHERE id='$product_id'");
        if(!$getSingleProductByIdQuery){
            $_SESSION['error_msg'] = "Invalid Product";
            $redirect = BASE_URL.'?q=sales/create';
            header("Location:$redirect");
        }
        $getSingleProduct = $getSingleProductByIdQuery->fetch_assoc();



        $salesQuery = "INSERT INTO sales (sales_unique_number,customer_id,sales_date,product_id,quantity,discount,subtotal,total_payble_amount,payment_type,transaction_id,status,note)";
        $salesQuery.=" VALUES ('$sales_unique_number','$customer_id','$sales_date','$product_id','$quantity','$discount','$subtotal','$total_payable_amount','$payment_type','$transaction_id','$status','$note')";
//        echo $salesQuery;
//        exit;
        $sales = $this->connection->query($salesQuery);
        if(!$sales){
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=sales/create';
            header("Location:$redirect");
            exit();
        }

        if($status == 'completed') {
            /**
             * Current Stock Update in Product Table when status is completed
             */
            $totalProductCuttentStock = $getSingleProduct['current_stock'] - $quantity;

            $productUpdateQuery = "UPDATE products SET current_stock='$totalProductCuttentStock' WHERE id='$product_id'";
            $product = $this->connection->query($productUpdateQuery);

            if ($product) {
                $_SESSION['success_msg'] = "Successfully Sales Created";
                $redirect = BASE_URL . '?q=sales/list';
                header("Location:$redirect");
                exit();
            } else {
                $deleteSalesQuery = "DELETE FROM sales ORDER BY id DESC LIMIT 1";
                $deleteSales = $this->connection->query($deleteSalesQuery);

                $_SESSION['error_msg'] = "Something went wrong. Please try again. Error: " . $this->connection->error;
                $redirect = BASE_URL . '?q=sales/create';
                header("Location:$redirect");
                exit();
            }
        }
        else{
            $_SESSION['success_msg'] = "Successfully Sales Created";
            $redirect = BASE_URL . '?q=sales/list';
            header("Location:$redirect");
        }
    }
    public function update()
    {
        $data = $_POST;
        $_SESSION['old_value'] = $data;
        $errors = [];
        if(empty($data['customer_id'])){
            $errors['customer_id']= 'Customer field is required';
        }
        if(empty($data['sales_date'])){
            $errors['sales_date']= 'Sales Date field is required';
        }
        if(empty($data['quantity'])){
            $errors['quantity']= 'Quantity field is required';
        }
        if(empty($data['product_id'])){
            $errors['product_id']= 'Product field is required';
        }
        if(empty($data['status'])){
            $errors['status']= 'Status field is required';
        }
        if(empty($data['payment_type'])){
            $errors['payment_type']= 'Payment Type field is required';
        }
        if(!empty($data['payment_type']) && $data['payment_type'] == 'online' && empty($data['transaction_id'])){
            $errors['transaction_id']= 'Transaction field is required';
        }

        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            $redirect = BASE_URL.'?q=sales/create';
            header("Location:$redirect");
            exit();
        }

        $customer_id = $data['customer_id'];
        $sales_date = date('Y-m-d',strtotime($data['sales_date']));
        $quantity = $data['quantity'];
        $product_id = $data['product_id'];
        $note = $data['note'];
        $status = $data['status'];
        $payment_type = $data['payment_type'];
        $discount = empty($data['discount']) ? 0 : $data['discount'];
        $subtotal = $data['subtotal'];
        $total_payable_amount = $data['total_payable_amount'];
        $transaction_id = $data['transaction_id'];
        $id = $data['sales_id'];


        $getSingleProductByIdQuery = $this->connection->query("SELECT * FROM products WHERE id='$product_id'");
        if(!$getSingleProductByIdQuery){
            $_SESSION['error_msg'] = "Invalid Product";
            $redirect = BASE_URL.'?q=sales/create';
            header("Location:$redirect");
        }
        $getSingleProduct = $getSingleProductByIdQuery->fetch_assoc();

        $salesQuery = "UPDATE sales SET customer_id='$customer_id',sales_date='$sales_date',product_id='$product_id',quantity='$quantity',discount='$discount',subtotal='$subtotal',";
        $salesQuery.="total_payble_amount='$total_payable_amount',payment_type='$payment_type',transaction_id='$transaction_id',status='$status',note='$note' WHERE id='$id'";
        $sales = $this->connection->query($salesQuery);
        if(!$sales){
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=sales/create';
            header("Location:$redirect");
            exit();
        }

        if($status == 'completed') {
            /**
             * Current Stock Update in Product Table when status is completed
             */
            $totalProductCuttentStock = $getSingleProduct['current_stock'] - $quantity;

            $productUpdateQuery = "UPDATE products SET current_stock='$totalProductCuttentStock' WHERE id='$product_id'";
            $product = $this->connection->query($productUpdateQuery);

            if ($product) {
                $_SESSION['success_msg'] = "Successfully Sales Created";
                $redirect = BASE_URL . '?q=sales/list';
                header("Location:$redirect");
                exit();
            } else {
                $deleteSalesQuery = "DELETE FROM sales ORDER BY id DESC LIMIT 1";
                $deleteSales = $this->connection->query($deleteSalesQuery);

                $_SESSION['error_msg'] = "Something went wrong. Please try again. Error: " . $this->connection->error;
                $redirect = BASE_URL . '?q=sales/create';
                header("Location:$redirect");
                exit();
            }
        }
        else{
            $_SESSION['success_msg'] = "Successfully Sales Created";
            $redirect = BASE_URL . '?q=sales/list';
            header("Location:$redirect");
        }
    }
    public function delete()
    {
        $id = $_POST['sales_id'];

        $query = "DELETE FROM sales WHERE id = '$id'";
        $result = $this->connection->query($query);
        if($result){

            $_SESSION['success_msg'] = "Successfully Sale Deleted";
            $redirect = BASE_URL.'?q=sales/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=sales/list';
            header("Location:$redirect");
        }
    }

    public function statusChange()
    {
        $id = $_POST['sales_id'];
        /** Get Sales details by product id*/
        $salesResult = $this->connection->query("SELECT * FROM sales WHERE id='$id'");
        if(!$salesResult){
            /** if any error on getting sales details data then we redirect to list page */
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=sales/list';
            header("Location:$redirect");
            exit();
        }
        $sales = $salesResult->fetch_assoc();
        $product_id = $sales['product_id'];


        /** Get Product information by product id. we get product id from sales details */
        $getSingleProductByIdQuery = $this->connection->query("SELECT * FROM products WHERE id='$product_id'");
        if (!$getSingleProductByIdQuery) {
            /** if any error on getting product details data then we redirect to list page */
            $_SESSION['error_msg'] = "Product Not Found Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=sales/list';
            header("Location:$redirect");
            exit();
        }

        $product = $getSingleProductByIdQuery->fetch_assoc();

        /** Calculate current stock */
        $totalProductCuttentStock = $product['current_stock'] - $sales['quantity'];

        /** Update current stock in product table */
        $productUpdateQuery = "UPDATE products SET current_stock='$totalProductCuttentStock' WHERE id='$product_id'";
        $product = $this->connection->query($productUpdateQuery);
        if(!$product){
            /** if any error on current stock update in product table then we redirect to list page */
            $_SESSION['error_msg'] = "Product Not Update. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=sales/list';
            header("Location:$redirect");
            exit();
        }

        /** Update purchase status to completed */
        $salesQuery = "UPDATE sales SET status='completed' WHERE id='$id'";
        $salesUpdate = $this->connection->query($salesQuery);

        if(!$salesUpdate){
            /** if any error on sales status update then we redirect to list page */
            $_SESSION['error_msg'] = "Sales not update Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=sales/list';
            header("Location:$redirect");
            exit();
        }

        /** Redirect list page with success message */
        $_SESSION['success_msg'] = "Sales Status Changed";
        $redirect = BASE_URL.'?q=sales/list';
        header("Location:$redirect");
    }
}