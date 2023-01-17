<?php
require("./index.php");
require("../session/authenticated.php");
require ('../controllers/UserController.php');
$user = new UserController();
switch($action){
    case "user_create":
        $user->create();
        break;
    case "user_edit":
        $user->update();
        break;
    case "user_delete":
        $user->delete();
        break;
}
