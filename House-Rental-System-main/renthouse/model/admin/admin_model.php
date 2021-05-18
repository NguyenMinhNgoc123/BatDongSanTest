<?php
class AdminDB{
    public static function getLogin($email,$password){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM admin where email='$email' AND password='$password' LIMIT 1";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function Logout($token){
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM session_admin WHERE token=:token ";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':token',$token);
            $statement1->execute();
            $result1  = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getCreateToken($token,$admin_id){
        $db = Database::getDB();
        try {
            $query1 = "INSERT INTO session_admin(token,admin_id) VALUES ('$token','$admin_id')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkTokenAdmin($admin_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM session_admin WHERE admin_id='$admin_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkToken($token){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM session_admin WHERE token='$token'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkNotify($tenant_id,$property_id,$type){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM notify WHERE tenant_id='$tenant_id' and property_id='$property_id' and type='$type' ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection1'.$error_message;
            exit();
        }
    }
}