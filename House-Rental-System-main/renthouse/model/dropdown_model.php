<?php
class dropdownDB{
    public static function getPropertyType(){
        $db = Database::getDB();
        try {
            $query1 = "select * from property_type ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getCity(){
        $db = Database::getDB();
        try {
            $query1 = "select * from city ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getDistrict(){
        $db = Database::getDB();
        try {
            $query1 = "select * from district ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getWard(){
        $db = Database::getDB();
        try {
            $query1 = "select * from ward ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getKindNews(){
        $db = Database::getDB();
        try {
            $query1 = "select * from kind_news ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getNumberWaiting(){
        $db = Database::getDB();
        try {
            $query1 = "select count(*) from add_property";
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
    public static function getBank(){
        $db = Database::getDB();
        try {
            $query1 = "select * from bank_account ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getPostType(){
        $db = Database::getDB();
        try {
            $query1 = "select * from post_type ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getNumber(){
        $db = Database::getDB();
        try {
            $query1 = "select * from post_type ";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
}