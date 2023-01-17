<?php
require(__DIR__."/../.env.php");
class MySqlConnection{
    
    public function connect(){
        @$conn = new mysqli(DATABASE_HOST,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
        return $conn;
    }
}