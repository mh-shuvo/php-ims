<?php
include(__DIR__."/index.php");
class CustomerController extends MySqlConnection
{
    public $connection = null;
    public function __construct(){
        $this->connection = $this->connect();
    }
    public function create()
    {
        $data = $_POST;
        $name = $data['name'];
        $phone = $data['phone'];
        $address = $data['address'];

        $_SESSION['old_value'] = $data;
        $errors = [];
        if(empty($data['name'])){
            $errors['name']= 'Name field is required';
        }
        if(empty($data['phone'])){
            $errors['phone']= 'Phone field is required';
        }
        if(empty($data['address'])){
            $errors['address']= 'Address field is required';
        }
        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            $redirect = BASE_URL.'?q=customer/create';
            header("Location:$redirect");
        }

        $query = "INSERT INTO customers (name,phone,address) VALUES ('$name','$phone','$address')";
        $result = $this->connection->query($query);
        if($result){
            $_SESSION['success_msg'] = "Successfully customer Added";
            $redirect = BASE_URL.'?q=customer/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=customer/create';
            header("Location:$redirect");
        }
    }
    public function update(){
        $data = $_POST;
        $name = $data['name'];
        $phone = $data['phone'];
        $address = $data['address'];
        $id = $data['id'];

        $_SESSION['old_value'] = $data;
        $errors = [];
        if(empty($data['name'])){
            $errors['name']= 'Name field is required';
        }
        if(empty($data['phone'])){
            $errors['phone']= 'Phone field is required';
        }
        if(empty($data['address'])){
            $errors['address']= 'Address field is required';
        }
        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            $redirect = BASE_URL.'?q=customer/edit&id='.$data['id'];
            header("Location:$redirect");
        }

        $query = "UPDATE customers SET name='$name',phone='$phone',address='$address' WHERE id='$id'";
        $result = $this->connection->query($query);

        if($result){
            $_SESSION['success_msg'] = "Successfully customer Updated";
            $redirect = BASE_URL.'?q=customer/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=customer/edit&id='.$data['id'];
            header("Location:$redirect");
        }
    }

    public function delete()
    {
        $id = $_POST['customer_id'];

        $query = "DELETE FROM customers WHERE id = '$id'";
        $result = $this->connection->query($query);
        if($result){

            $_SESSION['success_msg'] = "Successfully customer Deleted";
            $redirect = BASE_URL.'?q=customer/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=customer/list';
            header("Location:$redirect");
        }
    }
}