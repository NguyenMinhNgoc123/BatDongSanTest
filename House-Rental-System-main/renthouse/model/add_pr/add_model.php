<?php
class productAddDB{
    public static function CreateAddProducts($property_id, $tenant_id, $kind_id ,$caption, $chouse_id, $ptype_id,
                                                      $city_id, $district_id, $ward_id, $street, $apartment_number, $estimated_price, $land_area, $description)
    {
        $db = Database::getDB();
        try {
            $query1 = "INSERT INTO add_property(property_id,tenant_id,kind_id,caption,chouse_id,ptype_id,city_id
                ,district_id,ward_id,street,apartment_number,estimated_price,land_area,description)
                VALUES ('$property_id','$tenant_id','$kind_id','$caption','$chouse_id','$ptype_id','$city_id','$district_id','$ward_id','$street',
                        '$apartment_number','$estimated_price','$land_area','$description')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getImgage($p_photo,$property_id){
        $db = Database::getDB();
        try {
            $query1 = "INSERT INTO property_photo(property_photo_id,p_photo,property_id) values (null,'$p_photo','$property_id')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function createPayment($property_id,$tenant_id,$kind_id,$day_number,$price,$status,$start_status,$status_expires){
        $db = Database::getDB();
        try {
            $query1 = "INSERT INTO payment(property_id,tenant_id,kind_id,day_number,price,status,start_status,status_expires) values ('$property_id','$tenant_id','$kind_id','$day_number','$price','$status','$start_status','$status_expires')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
}