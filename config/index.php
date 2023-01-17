<?php
class Config {
    public static function getConfig($key){
        $key_parse = explode('.',$key);
        if(count($key_parse) <= 1 || !file_exists("./config/".$key_parse[0].".php")){
            return "Undefined Key";
        }

        $data = include("./config/".$key_parse[0].".php");
        return array_key_exists($key_parse[1],$data)?$data[$key_parse[1]]:"Undefined Key";
    }
}