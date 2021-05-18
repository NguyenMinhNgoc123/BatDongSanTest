<?php
class Database{
    private static $dsn = 'mysql:host=localhost;dbname=renthouse';
    private static $username ='root';
    private static $pass = '852654';
    private static $options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");//show chế độ hiển thị
    private static $db;
    public function __construct()
    {}
    public static function getDB(){
        if(!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,self::$username,self::$pass,self::$options);
                //echo 'connection';
            } catch (PDOException $exception)
            {
                $error_message = $exception->getMessage();
                echo 'error connection'.$error_message;
            }

        }
        return self::$db;
    }
}