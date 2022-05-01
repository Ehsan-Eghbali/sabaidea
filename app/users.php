<?php

use config\DB;

require_once __DIR__.'/../config/DB.php' ;

class users
{

    public function __construct()
    {
        $DB = new DB('user');
        $this->conn = $DB->conn;
    }
    public function insert($name)
    {

        $query = "INSERT INTO users (name) VALUES ('$name')";
        $result = mysqli_query($this->conn, $query);
        if($result){
            return 'با موفقیت اضافه شد';
        }else{
            return 'خطا';
        }
    }
    public function find($id)
    {
        $query = "SELECT * from users where id = '$id'";
        $result = mysqli_query($this->conn, $query);
        $result = $result->fetch_assoc();
        if($result){
            $_SESSION['user'] = $id;
            return $result['name'];
        }else{
            return 'خطا';
        }
    }
}