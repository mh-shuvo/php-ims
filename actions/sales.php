<?php
require("./index.php");
require("../session/authenticated.php");
require ('../controllers/SalesController.php');
$sales = new SalesController();

switch($action){
    case "sales_create":
        $sales->create();
        break;
    case "sales_edit":
        $sales->update();
        break;
    case "sales_delete":
        $sales->delete();
        break;
    case "sales_status_change":
        $sales->statusChange();
        break;
}
