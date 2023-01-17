<?php
session_start();
$msg=null;
$status = null;
$hasError = false;

if(isset($_SESSION['success_msg'])){
    $msg = $_SESSION['success_msg'];
    unset($_SESSION['success_msg']);
    $status = true;
}
if(isset($_SESSION['error_msg'])){
    $msg = $_SESSION['error_msg'];
    unset($_SESSION['error_msg']);
    $status = false;
    $hasError = true;
}

$isLoggedIn = isset($_SESSION['current_user']);
if(!$isLoggedIn){
    header("Location:./login.php");
    exit;
}
$currentUser = $_SESSION['current_user'];

$validation_errors = isset($_SESSION['validation_error']) ? $_SESSION['validation_error'] : [];
$oldValue = isset($_SESSION['old_value']) ? $_SESSION['old_value'] : [];

if(isset($_SESSION['validation_error'])){
    unset($_SESSION['validation_error']);
}

if(isset($_SESSION['old_value'])){
    unset($_SESSION['old_value']);
}