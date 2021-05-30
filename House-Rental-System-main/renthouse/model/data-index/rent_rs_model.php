<?php
class ProductDBRent {
    public static function getProducts($begin,$row_per_page){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property WHERE update_note < NOW() and note = '1' and ptype_id='2' ORDER BY Kind_id DESC , update_note DESC LIMIT {$begin},{$row_per_page}";
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
    public static function getProductsAdvRent(){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property WHERE update_note < NOW() and note = '1' and ptype_id='2' and kind_id='3'ORDER BY Kind_id DESC , update_note DESC ";
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
    public static function getImgAvatar($property_id){
        $db = Database::getDB();
        try {
            $query1 = "select * from property_photo where property_id = :property_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id',$property_id);
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
    public static function getProductsCount(){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property WHERE note = '1' and ptype_id='2' ";
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
    public static function getProductsVip(){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property WHERE update_note < NOW() and note = '1' and ptype_id='2' and kind_id='3' ORDER BY update_note DESC";
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
    public static function getProductsEndow(){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property WHERE update_note < NOW() and note = '1' and ptype_id='2' and kind_id='2' ORDER BY update_note DESC";
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
    public static function getProductsOften(){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property WHERE update_note < NOW() and note = '1' and ptype_id='2' and kind_id='2' ORDER BY update_note DESC";
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
    public static function getProductsSearchAll($begin,$row_per_page,$caption,$city_id,$district_id,$ward_id,$price_begin,$price_end,$land_area_begin,$land_area_end){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where update_note < NOW() and note = '1' and ptype_id='2' and estimated_price BETWEEN '$price_begin' AND '$price_end' AND land_area BETWEEN '$land_area_begin' AND '$land_area_end' 
                              AND city_id ='$city_id'AND district_id ='$district_id' AND ward_id ='$ward_id' AND concat(caption) like '%$caption%' ORDER BY kind_id DESC , update_note DESC LIMIT {$begin},{$row_per_page}";
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
    public static function getProductsSearchAllChouse($chouse_id,$begin,$row_per_page,$caption,$city_id,$district_id,$ward_id,$price_begin,$price_end,$land_area_begin,$land_area_end){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where update_note < NOW() and chouse_id ='$chouse_id' and note = '1' and ptype_id='2' and estimated_price BETWEEN '$price_begin' AND '$price_end' AND land_area BETWEEN '$land_area_begin' AND '$land_area_end' 
                              AND city_id ='$city_id'AND district_id ='$district_id' AND ward_id ='$ward_id' AND concat(caption) like '%$caption%' ORDER BY kind_id DESC , update_note DESC LIMIT {$begin},{$row_per_page}";
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
    public static function getProductsSearchCity($begin,$row_per_page,$caption,$city_id,$price_begin,$price_end,$land_area_begin,$land_area_end){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where update_note < NOW() and note = '1' and ptype_id='2' and estimated_price BETWEEN '$price_begin' AND '$price_end' AND land_area BETWEEN '$land_area_begin' AND '$land_area_end' 
                              AND city_id ='$city_id' AND concat(caption) like '%$caption%' ORDER BY kind_id DESC , update_note DESC LIMIT {$begin},{$row_per_page}";
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
    public static function getProductsSearchCityChouse($chouse_id,$begin,$row_per_page,$caption,$city_id,$price_begin,$price_end,$land_area_begin,$land_area_end){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where update_note < NOW() and chouse_id='$chouse_id' and note = '1' and ptype_id='2' and estimated_price BETWEEN '$price_begin' AND '$price_end' AND land_area BETWEEN '$land_area_begin' AND '$land_area_end' 
                              AND city_id ='$city_id' AND concat(caption) like '%$caption%' ORDER BY kind_id DESC , update_note DESC LIMIT {$begin},{$row_per_page}";
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
    public static function getProductsSearchCityDistrict($begin,$row_per_page,$caption,$city_id,$district_id,$price_begin,$price_end,$land_area_begin,$land_area_end){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where update_note < NOW() and note = '1' and ptype_id='2' and estimated_price BETWEEN '$price_begin' AND '$price_end' AND land_area BETWEEN '$land_area_begin' AND '$land_area_end' 
                              AND city_id ='$city_id'AND district_id ='$district_id' AND concat(caption) like '%$caption%' ORDER BY kind_id DESC , update_note DESC LIMIT {$begin},{$row_per_page}";
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
    public static function getProductsSearchCityDistrictChouse($chouse_id,$begin,$row_per_page,$caption,$city_id,$district_id,$price_begin,$price_end,$land_area_begin,$land_area_end){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where update_note < NOW() and chouse_id='$chouse_id' and note = '1' and ptype_id='2' and estimated_price BETWEEN '$price_begin' AND '$price_end' AND land_area BETWEEN '$land_area_begin' AND '$land_area_end' 
                              AND city_id ='$city_id'AND district_id ='$district_id' AND concat(caption) like '%$caption%' ORDER BY kind_id DESC , update_note DESC LIMIT {$begin},{$row_per_page}";
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
    public static function getProductsSearchNot($begin,$row_per_page,$caption,$price_begin,$price_end,$land_area_begin,$land_area_end){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where update_note < NOW() and note = '1' and ptype_id='2' and estimated_price BETWEEN '$price_begin' AND '$price_end' AND land_area BETWEEN '$land_area_begin' AND '$land_area_end' 
                              AND concat(caption) like '%$caption%' ORDER BY kind_id DESC , update_note DESC LIMIT {$begin},{$row_per_page}";
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
    public static function getProductsSearchNotChouse($chouse_id,$begin,$row_per_page,$caption,$price_begin,$price_end,$land_area_begin,$land_area_end){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where update_note < NOW() and chouse_id='$chouse_id' and note = '1' and ptype_id='2' and estimated_price BETWEEN '$price_begin' AND '$price_end' AND land_area BETWEEN '$land_area_begin' AND '$land_area_end' 
                              AND concat(caption) like '%$caption%' ORDER BY kind_id DESC , update_note DESC LIMIT {$begin},{$row_per_page}";
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