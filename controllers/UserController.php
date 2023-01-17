<?php
include(__DIR__."/index.php");
class UserController extends MySqlConnection
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
        if(empty($data['name'])){
            $errors['name']= 'Name field is required';
        }
        if(empty($data['phone'])){
            $errors['phone']= 'Phone field is required';
        }

        if(empty($data['email'])){
            $errors['email']= 'email field is required';
        }
        if(empty($data['password'])){
            $errors['password']= 'password field is required';
        }
        if(!empty($data['password']) && strlen($data['password']) < 6){
            $errors['password']= 'Password Length Should Be Greater Than Or Equal 6';
        }

        if(!empty($data['email']) && !filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
            $errors['email']= 'Invalid Email Address';
        }else{
            $email = $data['email'];
            $checkIsExists = $this->connection->query("SELECT * FROM user WHERE email='$email'");
            if($checkIsExists && $checkIsExists->num_rows > 0){
                $errors['email']= 'Email Already Exists.';
            }
        }

        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            $redirect = BASE_URL.'?q=user/create';
            header("Location:$redirect");
            exit;
        }

        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];
        $password = hash("sha256",$data['password']);

        $query = "INSERT INTO user (name,phone,email,password) VALUES ('$name','$phone','$email','$password')";
        $result = $this->connection->query($query);
        if($result){
            $_SESSION['success_msg'] = "Successfully User Created";
            $redirect = BASE_URL.'?q=user/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=user/create';
            header("Location:$redirect");
        }
    }
    public function update(){
        $data = $_POST;

        $id = $data['user_id'];
        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];

        $_SESSION['old_value'] = $data;
        $errors = [];
        if(empty($data['name'])){
            $errors['name']= 'Name field is required';
        }
        if(empty($data['phone'])){
            $errors['phone']= 'Phone field is required';
        }

        if(empty($data['email'])){
            $errors['email']= 'email field is required';
        }

        if(!empty($data['email']) && !filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
            $errors['email']= 'Invalid Email Address';
        }else{

            $checkIsExists = $this->connection->query("SELECT * FROM user WHERE email='$email' AND id !='$id'");
            if($checkIsExists && $checkIsExists->num_rows > 0){
                $errors['email']= 'Email Already Exists.';
            }
        }

        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            $redirect = BASE_URL.'?q=user/edit&id='.$id;
            header("Location:$redirect");
            exit;
        }


        $query = "UPDATE user SET name='$name',phone='$phone',email='$email' WHERE id='$id'";
        $result = $this->connection->query($query);
        if($result){
            $_SESSION['success_msg'] = "Successfully User Updated";
            $redirect = BASE_URL.'?q=user/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=user/edit&id='.$id;
            header("Location:$redirect");
        }
    }

    public function delete()
    {
        $id = $_POST['user_id'];

        $checkIsAlreadyUsed = $this->connection->query("SELECT * FROM products WHERE created_by='$id' OR updated_by='$id'");
        if($checkIsAlreadyUsed && $checkIsAlreadyUsed->num_rows > 0){
            $_SESSION['error_msg'] = "This user already added some product. Before delete should be delete all products of the user.";
            $redirect = BASE_URL.'?q=user/list';
            header("Location:$redirect");
            exit;
        }

        $query = "DELETE FROM user WHERE id = '$id'";
        $result = $this->connection->query($query);
        if($result){

            $_SESSION['success_msg'] = "Successfully user Deleted";
            $redirect = BASE_URL.'?q=user/list';
            header("Location:$redirect");
        }else{
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
            $redirect = BASE_URL.'?q=user/list';
            header("Location:$redirect");
        }
    }
}