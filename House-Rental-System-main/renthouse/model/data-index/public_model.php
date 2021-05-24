<?php
class productDB{
    public static function getProducts(){
        $db = Database::getDB();
        try {
            $query1 = "select * from add_property where note='1'";
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
    public static function getProductsCover(){
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property WHERE update_note < NOW() and note = '1' ORDER BY kind_id DESC,update_note DESC";
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
    public static function getProductDetails($property_id){
        $db = Database::getDB();
        try {
            $query1 = "select * from add_property where property_id =:property_id and (note='1' or note='0')";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id',$property_id);
            $statement1->execute();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getProductPtype($ptype_id){
        $db = Database::getDB();
        try {
            $query1 = "select * from post_type where ptype_id =:ptype_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':ptype_id',$ptype_id);
            $statement1->execute();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getCityName($city_id){
        $db = Database::getDB();
        try {
            $query1 = "select * from city where city_id =:city_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':city_id',$city_id);
            $statement1->execute();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getDistrictName($district_id){
        $db = Database::getDB();
        try {
            $query1 = "select * from district where district_id =:district_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':district_id',$district_id);
            $statement1->execute();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getWardName($ward_id){
        $db = Database::getDB();
        try {
            $query1 = "select * from ward where ward_id =:ward_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':ward_id',$ward_id);
            $statement1->execute();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getPropertyType($chouse_id){
        $db = Database::getDB();
        try {
            $query1 = "select * from property_type where chouse_id =:chouse_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':chouse_id',$chouse_id);
            $statement1->execute();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getTime($create_time){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date1 = $create_time;
        $date2 = date('Y/m/d H:i:s');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

//echo $years." năm, ".$months." tháng, ".$days." ngày, ".$hours." giờ, ".$minutes." phút, ".$seconds." giây";

        if ($years > 0) {
            $time = $years . ' năm trước';
        } else {
            if ($months > 0) {
                $time = $months . ' tháng trước';
            } else {
                if ($days > 0) {
                    $time = $days . ' ngày trước';
                } else {
                    if ($hours > 0) {
                        $time = $hours . ' giờ trước';
                    } else {
                        if ($minutes > 0) {
                            $time = $minutes . ' phút trước';
                        } else {
                            $time = $seconds . ' giây trước';
                        }
                    }
                }
            }
        }
        return $time;
    }
    public static function getPrice($number){
        if ($number == null){
            $result = '';
        }else{
            $number=str_replace(',', '', $number);

            $number=str_replace('.', '', $number);

            $number_fm1 = strlen($number);
            //xử lý tiền
            if ($number_fm1 > 9) {
                $number_fm2 = round(($number / 1000000000), 2);
                $result = $number_fm2 . ' tỷ';
            } elseif ($number_fm1 > 6) {
                $number_fm2 = round(($number / 1000000), 2);
                $result = $number_fm2 . ' triệu';
            } else {
                $number_fm2 = round(($number / 1000), 2);
                $result = $number_fm2 . ' ngàn';
            }
        }
        return $result;
    }
    public static function getGoogleMap($apartment_code,$street,$ward_name,$district_name,$city_name){
        if ($apartment_code == null){
            $string = $street.','.$ward_name.','.$district_name.','.$city_name;
        }else{
            $string = $apartment_code.','.$street.','.$ward_name.','.$district_name.','.$city_name;
        }
        return $string;
    }
    public static function getKindNews($kind_id){
        $db = Database::getDB();
        try {
            $query1 = "select * from kind_news where kind_id =:kind_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':kind_id',$kind_id);
            $statement1->execute();
            $result1 = $statement1->fetch();
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