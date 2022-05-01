<?php

use config\DB;

require_once __DIR__.'/../config/DB.php' ;

class domains
{
    public function __construct()
    {
        $DB = new DB('domains');
        $this->conn = $DB->conn;
        $this->baseUrl = 'example.com/';
        if ($_SESSION['user']){
            $this->user_id =$_SESSION['user'];
        }
    }
    public function insert($url)
    {
        $this->conn->begin_transaction();
        $url=urldecode($url);
        if (filter_var($url, FILTER_VALIDATE_URL))
            {
            $short_code = $this->generateUniqueID();
            $query = "INSERT INTO url_shorten (url, short_code,user_id) VALUES ('".$url."', '".$short_code."',$this->user_id)";
            $result = mysqli_query($this->conn, $query);
            if($result){
                $this->conn->commit();
                return $this->baseUrl.$short_code;
            }
        }
        $this->conn->rollback();
        return 'خطا';
    }
    public function update($id,$url)
    {
        $this->conn->begin_transaction();
        $query = "SELECT * from url_shorten where id = '$id' AND user_id = '$this->user_id'";
        $result = mysqli_query($this->conn, $query);
        if ($result->num_rows>0){

            $query = "update url_shorten set url = '$url'  where id = '$id'";
            $result = mysqli_query($this->conn, $query);
            $result = $result->fetch_assoc();
            if($result){
                $this->conn->commit();
                return $this->baseUrl.$result['short_code'];
            }

        }
        $this->conn->rollback();
        return 'خطا';

    }
    public function delete($id)
    {
        $this->conn->begin_transaction();
        $query = "SELECT * from url_shorten where id = '$id' AND user_id = '$this->user_id'";
        $result = mysqli_query($this->conn, $query);
        if ($result->num_rows>0){
            $query = "delete from url_shorten where id = '$id'";
            $result = mysqli_query($this->conn, $query);
            if($result){
                $this->conn->commit();
                return 'با موفقیت حذف شد';
            }
        }
        $this->conn->rollback();
        return 'خطا';

    }
    public function generateUniqueID(){

        $token = substr(md5(uniqid(rand(), true)),0,6);
        $query = "SELECT * FROM url_shorten WHERE short_code = '".$token."' ";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            $this->generateUniqueID();
        } else {
            return $token;
        }
    }
}