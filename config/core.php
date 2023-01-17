<?php
$page = isset($_GET['q']) ? $_GET['q'] : "dashboard";
$toInclude = './views/dashboard.php';
if($page != null){
    $path  = "./views/".$page.".php";
    if(file_exists($path)){
        $toInclude = $path;
    }else{
        header("Location:./errors",true);
        exit();
    }
}
define("CURRENT_PAGE",$page);
define('TO_INCLUDE',$toInclude);