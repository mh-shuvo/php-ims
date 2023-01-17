<?php
include("../controllers/index.php");
class AuthController extends MySqlConnection {
    public $connection = null;
    public function __construct(){
        $this->connection = $this->connect();
    }
    public function login(){
        $data = $_POST;
        $errors = [];
        if(empty($data['email'])){
            $errors['email']= 'Email field is required';
        }        
        if(empty($data['password'])){
            $errors['password']= 'Password field is required';
        }
        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            header("Location:../login.php");
        }

        $email = $data ['email'];
        $password = hash("sha256",$data['password']);

        $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
        $result = $this->connection->query($query);
        if($result->num_rows <= 0){
            $_SESSION['error_msg'] = "The credential do not match";
            header("Location:../login.php");
            exit;
        }

        $user = $result->fetch_assoc();
        $_SESSION['current_user'] = $user;
        $_SESSION['success_msg'] = "Successfully Loggedin";
        header("Location:../");
        exit;
    }

    public function forgotPassword()
    {
        $data = $_POST;
        $errors = [];
        if(empty($data['email'])){
            $errors['email']= 'Email field is required';
        }        
        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            header("Location:../forgot_password.php");
            exit();
        }
        $email = $data['email'];

        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = $this->connection->query($query);
        if($result->num_rows <= 0){
            $_SESSION['error_msg'] = "We don't found any account with the given email address.";
            header("Location:../forgot_password.php");
            exit;
        }
        $result_data = $result->fetch_assoc();
        header("Location:../password_reset.php?id=".$result_data['id']);
    }
    public function passwordReset(){
        $data = $_POST;
        $errors = [];
        if(empty($data['password'])){
            $errors['password']= 'Password field is required';
        }
        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            header("Location:../password_reset.php?id=".$data['id']);
            exit();
        }
        $password = hash("sha256",$data['password']);
        $id = $data['id'];
        $query = "UPDATE user SET password = '$password' WHERE id=$id";   
        $result = $this->connection->query($query);
        if(!$result){
            $_SESSION['error_msg'] = "Something went wrong. Error: ". $this->connection->error;
            header("Location:../password_reset.php?id=".$data['id']);
        }
        $_SESSION['success_msg'] = "Password Successfully Reset.";
        header("Location:../login.php");
    }

    public function profileUpdate(){
        $data = $_POST;
        $id = $_SESSION['current_user']['id'];
        $redirect = BASE_URL.'?q=profile';
        $errors = [];
        if(empty($data['name'])){
            $errors['name']= 'Name field is required';
        }        
        if(empty($data['email'])){
            $errors['email']= 'Email field is required';
        }
        if(!empty($data['email']) && !filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
            $errors['email']= 'Invalid Email Address';
        }        
        if(empty($data['phone'])){
            $errors['phone']= 'Phone field is required';
        }
        
        if(count($errors) > 0){
            $_SESSION['validation_error'] = $errors;
            header("Location:$redirect");
        }

        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        
        $query = "UPDATE user SET name='$name',email='$email',phone='$phone' WHERE id='$id'";

        $result = $this->connection->query($query);
        if(!$result){
            $_SESSION['error_msg'] = "Something went wrong. Error: ".$this->connection->error;
        }
        $_SESSION['success_msg'] = "Profile Successfully Updated";
        $_SESSION['current_user']['name'] = $name;
        $_SESSION['current_user']['email'] = $email;
        $_SESSION['current_user']['phone'] = $phone;
        header("Location:$redirect");
    }
    public function logout(){
        $isLoggedIn = isset($_SESSION['current_user']);
        if($isLoggedIn){
            unset($_SESSION['current_user']);
        }
        header("Location:../login.php");
    }
}