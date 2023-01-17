<?php
include(__DIR__."/index.php");
class PurchaseController extends MySqlConnection
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
        if(empty($data['supplier_id'])){
            $errors['supplier_id']= 'Supplier field is required';
        }
        if(empty($data['purchase_date'])){
            $errors['purchase_date']= 'Purchase Date field is required';
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

        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            $redirect = BASE_URL.'?q=purchase/create';
            header("Location:$redirect");
            exit();
        }

        $supplier_id = $data['supplier_id'];
        $purchase_date = date('Y-m-d',strtotime($data['purchase_date']));
        $quantity = $data['quantity'];
        $product_id = $data['product_id'];
        $note = $data['note'];
        $status = $data['status'];
        $purchase_unique_number = "PUR".time();

        $getSingleProductByIdQuery = $this->connection->query("SELECT * FROM products WHERE id='$product_id'");
        if(!$getSingleProductByIdQuery){
            $_SESSION['error_msg'] = "Invalid Product";
            $redirect = BASE_URL.'?q=purchase/create';
            header("Location:$redirect");
        }
        $getSingleProduct = $getSingleProductByIdQuery->fetch_assoc();

        $totalPurchase = $getSingleProduct['buying_price'] * $quantity;

        $pruchaseQuery = "INSERT INTO purchases (purchase_unique_number,supplier_id,date,total_purchase,product_id,quantity,note,status) VALUES ('$purchase_unique_number','$supplier_id','$purchase_date','$totalPurchase','$product_id','$quantity','$note','$status')";
        $purchase = $this->connection->query($pruchaseQuery);
        if(!$purchase){
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=purchase/create';
            header("Location:$redirect");
        }

        if($status == 'completed') {
            /**
             * Current Stock Update in Product Table when status is completed
             */
            $totalProductCuttentStock = $getSingleProduct['current_stock'] + $quantity;

            $productUpdateQuery = "UPDATE products SET current_stock='$totalProductCuttentStock' WHERE id='$product_id'";
            $product = $this->connection->query($productUpdateQuery);

            if ($product) {
                $_SESSION['success_msg'] = "Successfully Purchased";
                $redirect = BASE_URL . '?q=purchase/list';
                header("Location:$redirect");
            } else {
                $deletePurchaseQuery = "DELETE FROM purchases ORDER BY id DESC LIMIT 1";
                $deletePurchase = $this->connection->query($deletePurchaseQuery);

                $_SESSION['error_msg'] = "Something went wrong. Please try again. Error: " . $this->connection->error;
                $redirect = BASE_URL . '?q=purchase/create';
                header("Location:$redirect");
            }
        }
        else{
            $_SESSION['success_msg'] = "Successfully Purchase Create";
            $redirect = BASE_URL . '?q=purchase/list';
            header("Location:$redirect");
        }

    }
    public function update()
    {
        $data = $_POST;
        $_SESSION['old_value'] = $data;
        $errors = [];
        if(empty($data['supplier_id'])){
            $errors['supplier_id']= 'Supplier field is required';
        }
        if(empty($data['purchase_date'])){
            $errors['purchase_date']= 'Purchase Date field is required';
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

        if(count($errors) > 0){
            /**
             * If any validation error then redirect to edit page with all of errors
             */
            $_SESSION['validation_error'] = $errors;
            $redirect = BASE_URL.'?q=purchase/edit&id='.$data['purchase_id'];
            header("Location:$redirect");
            exit();
        }

        $supplier_id = $data['supplier_id'];
        $purchase_date = date('Y-m-d',strtotime($data['purchase_date']));
        $quantity = $data['quantity'];
        $product_id = $data['product_id'];
        $note = $data['note'];
        $status = $data['status'];
        $updated_at = date('Y-m-d');


        /**
         * Getting Product Information
         */

        $getSingleProductByIdQuery = $this->connection->query("SELECT * FROM products WHERE id='$product_id'");
        if(!$getSingleProductByIdQuery){
            $_SESSION['error_msg'] = "Invalid Product";
            $redirect = BASE_URL.'?q=purchase/edit&id='.$data['purchase_id'];
            header("Location:$redirect");
        }
        $getSingleProduct = $getSingleProductByIdQuery->fetch_assoc();

        /**
         * calculate total purchase amount. product buying price * product quantity
        */

        $totalPurchase = $getSingleProduct['buying_price'] * $quantity;

        /**
         * Update Purchase Data
         */
        $pruchaseQuery = "UPDATE purchases SET supplier_id='$supplier_id', date='$purchase_date',product_id='$product_id',quantity='$quantity',total_purchase='$totalPurchase',status='$status',note='$note',updated_at='$updated_at' WHERE id=".$data['purchase_id'];
        $purchase = $this->connection->query($pruchaseQuery);
        if(!$purchase){
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=purchase/edit&id='.$data['purchase_id'];
            header("Location:$redirect");
            exit();
        }

        if($status == 'completed') {
            /**
             * Current Stock Update in Product Table when status is completed
             */
            $totalProductCuttentStock = $getSingleProduct['current_stock'] + $quantity;

            $productUpdateQuery = "UPDATE products SET current_stock='$totalProductCuttentStock' WHERE id='$product_id'";
            $product = $this->connection->query($productUpdateQuery);

            if ($product) {
                $_SESSION['success_msg'] = "Successfully Purchased";
                $redirect = BASE_URL . '?q=purchase/list';
                header("Location:$redirect");
            } else {
                $_SESSION['error_msg'] = "Something went wrong. Please try again. Error: " . $this->connection->error;
                $redirect = BASE_URL.'?q=purchase/edit&id='.$data['purchase_id'];
                header("Location:$redirect");
            }
        }
        else{
            /**
             * when system entire this block it means purchase status is pending
             * If purchase status is not completed then just store data and redirect to the purchase list page with success page
             */
            $_SESSION['success_msg'] = "Successfully Purchase Create";
            $redirect = BASE_URL . '?q=purchase/list';
            header("Location:$redirect");
        }

    }
    public function delete()
    {
        $id = $_POST['purchase_id'];

        $query = "DELETE FROM purchases WHERE id = '$id'";
        $result = $this->connection->query($query);
        if($result){

            $_SESSION['success_msg'] = "Successfully Purchase Deleted";
            $redirect = BASE_URL.'?q=purchase/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=purchase/list';
            header("Location:$redirect");
        }
    }

    public function statusChange()
    {
        $id = $_POST['purchase_id'];

        /** Get Purchase details by product id*/
        $purchaseResult = $this->connection->query("SELECT * FROM purchases WHERE id='$id'");
        if(!$purchaseResult){
            /** if any error on getting purchase details data then we redirect to list page */
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=purchase/list';
            header("Location:$redirect");
            exit();
        }
        $purchase = $purchaseResult->fetch_assoc();
        $product_id = $purchase['product_id'];


        /** Get Product information by product id. we get product id from purchase details */
        $getSingleProductByIdQuery = $this->connection->query("SELECT * FROM products WHERE id='$product_id'");
        if (!$getSingleProductByIdQuery) {
            /** if any error on getting product details data then we redirect to list page */
            $_SESSION['error_msg'] = "Product Not Found Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=purchase/list';
            header("Location:$redirect");
            exit();
        }

        $product = $getSingleProductByIdQuery->fetch_assoc();

        /** Calculate current stock */
        $totalProductCuttentStock = $product['current_stock'] + $purchase['quantity'];

        /** Update current stock in product table */
        $productUpdateQuery = "UPDATE products SET current_stock='$totalProductCuttentStock' WHERE id='$product_id'";
        $product = $this->connection->query($productUpdateQuery);
        if(!$product){
            /** if any error on current stock update in product table then we redirect to list page */
            $_SESSION['error_msg'] = "Product Not Update. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=purchase/list';
            header("Location:$redirect");
            exit();
        }

        /** Update purchase status to completed */
        $purchaseQuery = "UPDATE purchases SET status='completed' WHERE id='$id'";
        $purchaseUpdate = $this->connection->query($purchaseQuery);

        if(!$purchaseUpdate){
            /** if any error on purchase status update then we redirect to list page */
            $_SESSION['error_msg'] = "Purchase not update Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=purchase/list';
            header("Location:$redirect");
            exit();
        }

        /** Redirect list page with success message */
        $_SESSION['success_msg'] = "Purchase Status Changed";
        $redirect = BASE_URL.'?q=purchase/list';
        header("Location:$redirect");
    }
}