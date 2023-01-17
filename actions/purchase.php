<?php
require("./index.php");
require("../session/authenticated.php");
require ('../controllers/PurchaseController.php');
$purchase = new PurchaseController();

switch($action){
    case "purchase_create":
        $purchase->create();
        break;
    case "purchase_edit":
        $purchase->update();
        break;
    case "purchase_delete":
        $purchase->delete();
        break;
    case "purchase_status_change":
        $purchase->statusChange();
        break;
}
