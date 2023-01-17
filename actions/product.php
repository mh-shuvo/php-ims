<?php
require("./index.php");
require("../session/authenticated.php");
require ('../controllers/ProductController.php');
$product = new ProductController();
switch($action){
    case "product_create":
        $product->create();
        break;
    case "product_edit":
        $product->update();
        break;
    case "product_delete":
        $product->delete();
        break;
}
