<?php
require("./index.php");
require("../session/authenticated.php");
require ('../controllers/CustomerController.php');
$customer = new CustomerController();
switch($action){
    case "customer_create":
        $customer->create();
        break;
    case "customer_edit":
        $customer->update();
        break;
    case "customer_delete":
        $customer->delete();
        break;
}
