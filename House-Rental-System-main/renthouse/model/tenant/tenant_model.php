<?php
class tenantDB
{
    public static function addTenantID($tenant_id, $full_name, $email, $password, $phone_no, $sex, $status)
    {
        $db = Database::getDB();
        try {
            $query1 = "INSERT INTO tenant(tenant_id,full_name,email,password,phone_no,sex,status) VALUES (:tenant_id,:full_name,:email,:password,:phone_no,:sex,:status)";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':tenant_id', $tenant_id);
            $statement1->bindParam(':full_name', $full_name);
            $statement1->bindParam(':email', $email);
            $statement1->bindParam(':password', $password);
            $statement1->bindParam(':phone_no', $phone_no);
            $statement1->bindParam(':sex', $sex);
            $statement1->bindParam(':status', $status);
            $statement1->execute();
            $statement1->closeCursor();
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function getLogin($email, $password)
    {
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM tenant where email='$email' AND password='$password' LIMIT 1";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function Logout($token)
    {
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM session_tenant WHERE token=:token ";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':token', $token);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function getCreateToken($token, $fresh_token, $token_expired, $fresh_token_expired, $tenant_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "INSERT INTO session_tenant(token,fresh_token,token_expired,fresh_token_expired,tenant_id) VALUES ('$token','$fresh_token','$token_expired','$fresh_token_expired','$tenant_id')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function getProfile($tenant_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM tenant where tenant_id='$tenant_id' LIMIT 1";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function Update($tenant_id, $full_name, $phone_no, $address, $id_photo, $sex)
    {
        $db = Database::getDB();
        try {
            $query1 = "UPDATE tenant SET full_name='$full_name',phone_no='$phone_no',address='$address',sex_id='$sex',id_photo='$id_photo' WHERE tenant_id='$tenant_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function getToken($code, $email)
    {
        $db = Database::getDB();
        try {
            $query1 = "UPDATE tenant SET code = '$code' WHERE email = '$email'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function changPassword($tenant_id, $password)
    {
        $db = Database::getDB();
        try {
            $query1 = "UPDATE tenant SET password='$password' WHERE tenant_id='$tenant_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function changPasswordForgot($email, $password)
    {
        $db = Database::getDB();
        try {
            $query1 = "UPDATE tenant SET password='$password',code=null WHERE email='$email'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }


    public static function getProductTenant($tenant_id, $note)
    {
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where tenant_id='$tenant_id' and note = '$note'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getProductTenantNote($tenant_id,$note_0,$note_1)
    {
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where tenant_id='$tenant_id' and (note='$note_0' or note='$note_1')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getProductTenantPtype($tenant_id,$ptype_id,$note_0,$note_1)
    {
        $db = Database::getDB();
        try {
            $query1 = "SELECT * FROM add_property where tenant_id='$tenant_id' and ptype_id='$ptype_id' and (note='$note_0' or note='$note_1')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getProductDetails($property_id, $tenant_id, $note0,$note1,$note2)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from add_property where property_id =:property_id and tenant_id=:tenant_id and (note=:note0 or note=:note1 or note=:note2)";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id', $property_id);
            $statement1->bindParam(':tenant_id', $tenant_id);
            $statement1->bindParam(':note0', $note0);
            $statement1->bindParam(':note1', $note1);
            $statement1->bindParam(':note2', $note2);
            $statement1->execute();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function DeleteProducts($property_id,$tenant_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM add_property WHERE property_id=:property_id and tenant_id=:tenant_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id', $property_id);
            $statement1->bindParam(':tenant_id', $tenant_id);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function DeleteImage($property_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM property_photo WHERE property_id=:property_id ";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id', $property_id);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function DeletePayment($property_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "DELETE FROM payment WHERE property_id=:property_id ";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id', $property_id);
            $statement1->execute();
            $result1 = $statement1->rowCount();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function ListImage($property_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from property_photo where property_id =:property_id ";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':property_id', $property_id);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }

    public static function getPayment($property_id,$tenant_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from payment where property_id ='$property_id' and tenant_id ='$tenant_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            //$statement1->rowCount();
            $result1 = $statement1->fetch();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
//    public static function getTimeExpires($create_time)
//    {
//        date_default_timezone_set('Asia/Ho_Chi_Minh');
//        $date1 = date('Y/m/d H:i:s');
//        $date2 = $create_time;
//        $diff = abs(strtotime($date2) - strtotime($date1));
//        $years = floor($diff / (365 * 60 * 60 * 24));
//        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
//        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
//        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
//        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
//        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));
//
//        //echo $years." năm, ".$months." tháng, ".$days." ngày ".$hours." giờ".$minutes." phút, ".$seconds." giây";
//        if ((strtotime($date2) - strtotime($date1)) > 0){
//            if ($days < 3){
//                if ($days > 0 ){
//                    $time = $days." ngày ".$hours." giờ ".$minutes." phút ".$seconds." giây";
//                }else if ($hours > 0){
//                    $time = $hours." giờ ".$minutes." phút ".$seconds." giây";
//                }else if ($minutes > 0){
//                    $time = $minutes." phút ".$seconds." giây";
//                }else{
//                    $time = $seconds." giây";
//                }
//            }  else{
//                $time = 0;
//            }
//        } else{
//            $time = 0;
//        }
//        return $time;
//    }
    public static function getTimeExpiresPaid($end_date)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date1 = date('Y/m/d H:i:s');
        $date2 = $end_date;
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

        //echo $years." năm, ".$months." tháng, ".$days." ngày ".$hours." giờ".$minutes." phút, ".$seconds." giây";
        if ($months == 0){
            if ($days > 0 ){
                $time = $days." ngày ".$hours." giờ ".$minutes." phút ".$seconds." giây";
            }else if ($hours > 0){
                $time = $hours." giờ ".$minutes." phút ".$seconds." giây";
            }else if ($minutes > 0){
                $time = $minutes." phút ".$seconds." giây";
            }else{
                $time = $seconds." giây";
            }
        }else{
            $time = 0;
        }
        return $time;
    }
    public static function getNotify($tenant_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from notify where tenant_id =:tenant_id ";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':tenant_id', $tenant_id);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function continueProduct($property_id,$note,$update_note){
        $db = Database::getDB();
        try {
            $query1 = "UPDATE add_property SET note='$note',update_note='$update_note' WHERE property_id='$property_id'";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->closeCursor();
        }catch (PDOException $exception){
            $error_message = $exception->getMessage();
            echo 'error connection'.$error_message;
            exit();
        }
    }
    public static function getChat($tenant_id)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from chat where tenant_id =:tenant_id ";
            $statement1 = $db->prepare($query1);
            $statement1->bindParam(':tenant_id', $tenant_id);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
    public static function getMessages($tenant_id_main,$tenant_id_extra)
    {
        $db = Database::getDB();
        try {
            $query1 = "select * from messages where (incoming_msg_id ='$tenant_id_main' or incoming_msg_id='$tenant_id_extra') and (outgoing_msg_id ='$tenant_id_main' or outgoing_msg_id='$tenant_id_extra')";
            $statement1 = $db->prepare($query1);
            $statement1->execute();
            $statement1->rowCount();
            $result1 = $statement1->fetchAll();
            $statement1->closeCursor();
            return $result1;
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            echo 'error connection' . $error_message;
            exit();
        }
    }
}
