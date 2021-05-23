<?php
class Check_existDB{
    public static function checkEmail($email){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM tenant WHERE email='$email'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkPhone($phone_no){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM tenant WHERE phone_no='$phone_no'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkTokenTenant($tenant_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM session_tenant WHERE tenant_id='$tenant_id'";
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
            $query1 = "SELECT * FROM session_tenant WHERE token='$token'";
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
    public static function checkPassword($tenant_id,$password){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM tenant WHERE tenant_id='$tenant_id' and password='$password'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 =$statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkTenant($tenant_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM tenant WHERE tenant_id='$tenant_id'";
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
    public static function checkOTP($email,$otp){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM tenant WHERE email='$email' and code='$otp'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 =$statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkExistProducts($property_id,$tenant_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property WHERE property_id='$property_id' and tenant_id='$tenant_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 =$statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkExistKindNews($kind_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM kind_news WHERE kind_id='$kind_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 =$statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkExistPropertyType($chouse_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM property_type WHERE chouse_id='$chouse_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 =$statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkExistPostType($ptype_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM post_type WHERE ptype_id='$ptype_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 =$statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkProperty($property_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property WHERE property_id='$property_id' ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 =$statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkPropertyNote2($property_id,$tenant_id,$note){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property WHERE property_id='$property_id' and tenant_id='$tenant_id' and note ='$note'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 =$statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function checkPotential($tenant_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM potential_customers WHERE tenant_id='$tenant_id'";
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
    public static function checkGrade($grade_id){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM grade WHERE grade_id='$grade_id'";
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
}