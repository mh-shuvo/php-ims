<?php
if($_SERVER['REQUEST_METHOD'] != 'POST' || (!isset($_POST['action']) || empty($_POST['action']))){
    header("Location:../errors/?code=400");
}
$action = $_POST['action'];