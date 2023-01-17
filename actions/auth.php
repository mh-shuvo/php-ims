<?php
require("./index.php");
require ('../controllers/AuthController.php');

$authController = new AuthController();
switch($action){
    case "login":
        $authController->login();
    break;
    case "forgot_password":
        $authController->forgotPassword();
        break;
    case 'password_reset':
        $authController->passwordReset();
        break;
    case 'logout':
        $authController->logout();
        break;        
    case 'profile_update':
        $authController->profileUpdate();
        break;
    default:
        header("Location:../errors/?code=400");
    break;
}