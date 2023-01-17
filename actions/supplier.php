<?php
require("./index.php");
require("../session/authenticated.php");
require ('../controllers/SupplierController.php');
$supplier = new SupplierController();
switch($action){
    case "supplier_create":
        $supplier->create();
        break;
    case "supplier_edit":
        $supplier->update();
        break;
    case "supplier_delete":
        $supplier->delete();
        break;
}
