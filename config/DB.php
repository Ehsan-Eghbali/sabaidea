<?php
namespace config;
use mysqli;

class DB{
    const host = 'localhost';
    const user = 'root';
    const passwd = '';
    const table = 'test';


    public function __construct($table)
    {
        $conn = mysqli_connect(self::host,self::user,self::passwd,self::table);
        $conn->set_charset('UTF8');
        if (!$conn)
        {
            die ("<h1>خطا در اتصال به دیتابیس</h1>". mysqli_connect_error());
        }
        // echo "Database Connected Successfully";
        return $this->conn = $conn;
    }
}
