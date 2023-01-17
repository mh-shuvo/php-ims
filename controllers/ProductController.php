<?php
include(__DIR__."/index.php");
class ProductController extends MySqlConnection{
    public $connection = null;
    public function __construct(){
        $this->connection = $this->connect();
    }
    public function create(){
        $data = $_POST;
        $files = $_FILES;
        $product_name = $data['product_name'];
        $product_code = $data['product_code'];
        $buying_price = $data['buying_price'];
        $selling_price = $data['selling_price'];
        $status = $data['status'];

        $errors = [];
        if(empty($data['product_name'])){
            $errors['product_name']= 'Product Name field is required';
        }        
        if(empty($data['product_code'])){
            $errors['product_code']= 'Product Code field is required';
        }
        if(!empty($data['product_code'])){
            $product_code = $data['product_code'];
            $query = "SELECT * FROM products WHERE product_code='$product_code'";
            $result = $this->connection->query($query);
            if($result->num_rows > 0){
                $errors['product_code']= 'Product Code is already exists.';
            }
        }
        if(empty($data['buying_price'])){
            $errors['buying_price']= 'Buying Price field is required';
        }        
        if(empty($data['selling_price'])){
            $errors['selling_price']= 'Selling Price field is required';
        }                
        if(empty($data['status'])){
            $errors['status']= 'Status field is required';
        }
        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            $redirect = BASE_URL.'?q=product/create';
            header("Location:$redirect");
        }
        $fileName = '';
        if($files['product_image']['name'] != null){
            $image = $files['product_image'];
            $type = explode("/",$image['type']); //[0] = image, [1]=jpg
            $target_dir = "../".UPLOAD_DIR; //../upload/
            $fileName = "product/".time().'.'.$type[1]; //product/109234289.jpg
            $isUpload = move_uploaded_file($image['tmp_name'],($target_dir.''.$fileName)); // ../upload/product/109234289.jpg
            if(!$isUpload){
                echo "Something went wrong. File Not upload";
                exit;
            }
        }

        $created_by = $_SESSION['current_user']['id'];
        
        $query = "INSERT INTO products (product_name,product_code,buying_price,selling_price,status,created_by,product_image) VALUES ('$product_name','$product_code','$buying_price','$selling_price','$status','$created_by','$fileName')";

        $result = $this->connection->query($query);
        if($result){
            $_SESSION['success_msg'] = "Successfully Product Uploaded";
            $redirect = BASE_URL.'?q=product/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=product/create';
            header("Location:$redirect");
        }
    }

    public function update(){
        $data = $_POST;
        $files = $_FILES;
        $product_name = $data['product_name'];
        $product_code = $data['product_code'];
        $buying_price = $data['buying_price'];
        $selling_price = $data['selling_price'];
        $id = $data['product_id'];
        $status = $data['status'];

        $errors = [];
        if(empty($data['product_name'])){
            $errors['product_name']= 'Product Name field is required';
        }
        if(empty($data['product_code'])){
            $errors['product_code']= 'Product Code field is required';
        }
        if(!empty($data['product_code'])){
            $product_code = $data['product_code'];
            $query = "SELECT * FROM products WHERE product_code='$product_code' AND id != $id";
            $result = $this->connection->query($query);
            if($result->num_rows > 0){
                $errors['product_code']= 'Product Code is already exists.';
            }
        }
        if(empty($data['buying_price'])){
            $errors['buying_price']= 'Buying Price field is required';
        }
        if(empty($data['selling_price'])){
            $errors['selling_price']= 'Selling Price field is required';
        }
        if(empty($data['status'])){
            $errors['status']= 'Status field is required';
        }
        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            $redirect = BASE_URL.'?q=product/edit&id='.$id;
            header("Location:$redirect");
        }

        $productQuery = $this->connection->query("SELECT * FROM products WHERE id=$id");
        $product = $productQuery->fetch_assoc();

        $fileName = $product['product_image'];
        if($files['product_image']['name'] != null){
            $image = $files['product_image'];
            $type = explode("/",$image['type']); //[0] = image, [1]=jpg
            $target_dir = "../".UPLOAD_DIR; //../upload/
            $fileName = "product/".time().'.'.$type[1]; //product/109234289.jpg
            $isUpload = move_uploaded_file($image['tmp_name'],($target_dir.''.$fileName)); // ../upload/product/109234289.jpg
            if(!$isUpload){
                echo "Something went wrong. File Not upload";
                exit;
            }
        }

        $updated_by = $_SESSION['current_user']['id'];

        $query = "UPDATE products SET product_name='$product_name',product_code='$product_code',buying_price='$buying_price',selling_price='$selling_price',status='$status',product_image='$fileName',updated_by='$updated_by' WHERE id='$id'";
        $result = $this->connection->query($query);
        if($result){
            if($files['product_image']['name'] != null){
                if(file_exists("../".UPLOAD_DIR.''.$product['product_image'])){
                    unlink("../".UPLOAD_DIR.''.$product['product_image']);
                }
            }
            $_SESSION['success_msg'] = "Successfully Product Updated";
            $redirect = BASE_URL.'?q=product/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=product/edit&id='.$id;
            header("Location:$redirect");
        }
    }
    public function delete(){
        $id = $_POST['product_id'];

        $productQuery = $this->connection->query("SELECT * FROM products WHERE id=$id");
        $product = $productQuery->fetch_assoc();

        $query = "DELETE FROM products WHERE id = '$id'";
        $result = $this->connection->query($query);
        if($result){
            if(file_exists("../".UPLOAD_DIR.''.$product['product_image'])){
                unlink("../".UPLOAD_DIR.''.$product['product_image']);
            }
            $_SESSION['success_msg'] = "Successfully Product Deleted";
            $redirect = BASE_URL.'?q=product/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=product/list';
            header("Location:$redirect");
        }
    }
}