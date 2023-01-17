<?php
class Helper{
    
    public static function setMenuActive($param){
        $splitCurrentUrl = explode("/",CURRENT_PAGE);
        if($param == $splitCurrentUrl[0]){
            return "active";
        }
        else{
            return null;
        }
    }
    public static function old($key){
        if(count($oldValue)<=0){
            return null;
        }

        if(array_key_exists($key,$oldValue)){
            return $oldValue[$key];
        }
        return null;
    }
}